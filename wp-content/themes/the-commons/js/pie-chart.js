(function () {
    const svg = document.getElementById('pieChartSvg');
    const slicePaths = Array.from(svg.querySelectorAll('.slice'));
    const sliceLabels = Array.from(svg.querySelectorAll('.slice-label'));
    const handlesGroup = svg.querySelector('.handles');
    const resetButton = document.getElementById('pieChartReset');
    const svgNS = 'http://www.w3.org/2000/svg';
    const radius = 140;
    const labelRadius = 84;
    const minGap = 8;
    let boundaries = [0, 120, 240];
    let activeHandleIndex = null;
    let pointerAngleOffset = 0;

    function normalize(angle) {
        return ((angle % 360) + 360) % 360;
    }

    function degToRad(degrees) {
        return degrees * (Math.PI / 180);
    }

    function polarToCartesian(angle, radiusValue) {
        const radians = degToRad(angle - 90);
        return {
            x: Math.cos(radians) * radiusValue,
            y: Math.sin(radians) * radiusValue,
        };
    }

    function describeArc(startAngle, endAngle, radiusValue) {
        const start = polarToCartesian(endAngle, radiusValue);
        const end = polarToCartesian(startAngle, radiusValue);
        const largeArcFlag = endAngle - startAngle <= 180 ? '0' : '1';
        return [
            'M', start.x, start.y,
            'A', radiusValue, radiusValue, 0, largeArcFlag, 0, end.x, end.y,
            'L', 0, 0,
            'Z'
        ].join(' ');
    }
    function createTrianglePoints(angle) {
        const tipPos = polarToCartesian(angle, radius);
        const backLeftPos = polarToCartesian(angle - 25, radius + 18);
        const backRightPos = polarToCartesian(angle + 25, radius + 18);
        return `${tipPos.x},${tipPos.y} ${backLeftPos.x},${backLeftPos.y} ${backRightPos.x},${backRightPos.y}`;
    }
    function clampAngle(rawAngle, low, high) {
        let candidate = normalize(rawAngle);
        while (candidate < low) {
            candidate += 360;
        }
        while (candidate > high) {
            candidate -= 360;
        }
        if (candidate < low) {
            candidate = low;
        }
        if (candidate > high) {
            candidate = high;
        }
        return normalize(candidate);
    }

    function getSortedBoundaries() {
        return boundaries
            .map((angle, index) => ({ angle, index }))
            .sort((a, b) => a.angle - b.angle);
    }

    function updateBoundary(index, rawAngle) {
        const sorted = getSortedBoundaries();
        const active = sorted.find((item) => item.index === index);
        const activeIndex = sorted.indexOf(active);
        const prev = sorted[(activeIndex + 2) % 3];
        const next = sorted[(activeIndex + 1) % 3];
        let low = prev.angle + minGap;
        let high = next.angle - minGap;
        if (prev.angle >= next.angle) {
            high += 360;
        }
        boundaries[index] = clampAngle(rawAngle, low, high);
    }

    function getPointerAngle(event) {
        const point = svg.createSVGPoint();
        point.x = event.clientX;
        point.y = event.clientY;
        const cursorPoint = point.matrixTransform(svg.getScreenCTM().inverse());
        const dx = cursorPoint.x - 160;
        const dy = cursorPoint.y - 160;
        let angle = Math.atan2(dy, dx) * (180 / Math.PI);
        if (angle < 0) {
            angle += 360;
        }
        return angle;
    }

    function render() {
        const sorted = getSortedBoundaries();
        const arcAngles = [
            { start: sorted[0].angle, end: sorted[1].angle },
            { start: sorted[1].angle, end: sorted[2].angle },
            { start: sorted[2].angle, end: sorted[0].angle + 360 },
        ];

        arcAngles.forEach((arc, index) => {
            slicePaths[index].setAttribute('d', describeArc(arc.start, arc.end, radius));
            const midAngle = (arc.start + arc.end) / 2;
            const labelPos = polarToCartesian(midAngle, labelRadius);
            sliceLabels[index].setAttribute('x', labelPos.x);
            sliceLabels[index].setAttribute('y', labelPos.y);
            const percent = Math.round(((arc.end - arc.start) / 360) * 100);
            sliceLabels[index].textContent = `${percent}%`;
        });

        handlesGroup.innerHTML = '';
        boundaries.forEach((angle, index) => {
            const handle = document.createElementNS(svgNS, 'polygon');
            handle.classList.add('handle');
            handle.setAttribute('points', createTrianglePoints(angle));
            handle.setAttribute('data-handle-index', index);
            handle.setAttribute('aria-label', 'Drag to adjust slice ratio');
            handle.setAttribute('role', 'slider');
            handle.setAttribute('tabindex', '-1');
            handlesGroup.appendChild(handle);
        });
    }

    function findHandleFromEvent(event) {
        const target = event.target;
        if (target.matches('.handle')) {
            return Number(target.getAttribute('data-handle-index'));
        }
        return null;
    }

    function onPointerDown(event) {
        const index = findHandleFromEvent(event);
        if (index === null) {
            return;
        }
        activeHandleIndex = index;
        const pointerAngle = getPointerAngle(event);
        const boundaryAngle = boundaries[index];
        pointerAngleOffset = normalize(boundaryAngle - pointerAngle);
        event.target.setPointerCapture(event.pointerId);
        event.preventDefault();
    }

    function onPointerMove(event) {
        if (activeHandleIndex === null) {
            return;
        }
        const rawPointerAngle = getPointerAngle(event);
        const angle = normalize(rawPointerAngle + pointerAngleOffset);
        updateBoundary(activeHandleIndex, angle);
        render();
        event.preventDefault();
    }

    function onPointerUp(event) {
        if (activeHandleIndex !== null) {
            activeHandleIndex = null;
            event.preventDefault();
        }
    }

    function resetChart() {
        boundaries = [0, 120, 240];
        render();
    }

    handlesGroup.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointermove', onPointerMove);
    window.addEventListener('pointerup', onPointerUp);
    window.addEventListener('pointercancel', onPointerUp);
    resetButton.addEventListener('click', resetChart);

    render();
})();
