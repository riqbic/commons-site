(function () {
    const svg = document.getElementById('pieChartSvg');
    const slicePaths = Array.from(svg.querySelectorAll('.slice'));
    const sliceLabels = Array.from(svg.querySelectorAll('.slice-label'));
    const handlesGroup = svg.querySelector('.handles');
    const resetButton = document.getElementById('pieChartReset');
    const svgNS = 'http://www.w3.org/2000/svg';
    const radius = 140;
    const labelRadius = 84;
    const minGap = 2;
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
        const tipPos = polarToCartesian(angle, radius + 6);
        const backLeftPos = polarToCartesian(angle - 3, radius + 16);
        const backRightPos = polarToCartesian(angle + 3, radius + 16);
        return `${tipPos.x},${tipPos.y} ${backLeftPos.x},${backLeftPos.y} ${backRightPos.x},${backRightPos.y}`;
    }
    function clampAngle(rawAngle, low, high) {
        const angle = normalize(rawAngle);
        if (high < low) {
            high += 360;
        }

        const candidates = [angle, angle + 360];
        let best = null;
        let bestDistance = Infinity;

        for (const candidate of candidates) {
            if (candidate >= low && candidate <= high) {
                return normalize(candidate);
            }

            const distance = candidate < low ? low - candidate : candidate > high ? candidate - high : 0;
            if (distance < bestDistance) {
                bestDistance = distance;
                best = candidate < low ? low : high;
            }
        }

        return normalize(best);
    }

    function getSortedBoundaries() {
        return boundaries
            .map((angle, index) => ({ angle, index }))
            .sort((a, b) => a.angle - b.angle);
    }

    function updateBoundary(index, rawAngle) {
        const prevAngle = normalize(boundaries[(index + 2) % 3]);
        const nextAngle = normalize(boundaries[(index + 1) % 3]);
        let low = prevAngle + minGap;
        let high = nextAngle - minGap;
        if (prevAngle >= nextAngle) {
            high += 360;
        }
        boundaries[index] = clampAngle(rawAngle, low, high);
    }

    function getPointerAngle(event) {
        const point = svg.createSVGPoint();
        point.x = event.clientX;
        point.y = event.clientY;
        const cursorPoint = point.matrixTransform(svg.getScreenCTM().inverse());
        const dx = cursorPoint.x - 210;
        const dy = cursorPoint.y - 180;
        let angle = Math.atan2(dy, dx) * (180 / Math.PI);
        if (angle < 0) {
            angle += 360;
        }
        return angle;
    }

    function render() {
        const sliceNames = Array.from(svg.querySelectorAll('.slice-name'));
        const sliceBoxes = Array.from(svg.querySelectorAll('.slice-name-box'));

        boundaries.forEach((startAngle, index) => {
            const endAngle = normalize(boundaries[(index + 1) % 3]);
            const span = normalize(endAngle - startAngle);
            const arcEnd = startAngle + span;
            slicePaths[index].setAttribute('d', describeArc(startAngle, arcEnd, radius));

            const midAngle = startAngle + span / 2;
            const labelPos = polarToCartesian(midAngle, labelRadius);
            sliceLabels[index].setAttribute('x', labelPos.x);
            sliceLabels[index].setAttribute('y', labelPos.y);
            const rawPercent = (span / 360) * 100;
            const percent = Math.round(rawPercent);
            sliceLabels[index].textContent = `${percent}%`;
            const showLabel = rawPercent >= 1;
            sliceLabels[index].setAttribute('display', showLabel ? 'inline' : 'none');

            if (sliceNames[index]) {
                const namePos = polarToCartesian(midAngle, radius + 30);
                const nameText = sliceNames[index];
                nameText.setAttribute('x', namePos.x);
                nameText.setAttribute('y', namePos.y);
                nameText.setAttribute('text-anchor', namePos.x < 0 ? 'end' : 'start');
                if (namePos.x === 0) {
                    nameText.setAttribute('text-anchor', 'middle');
                }
                if (showLabel) {
                    nameText.setAttribute('display', 'inline');
                    const box = sliceBoxes[index];
                    if (box) {
                        const bbox = nameText.getBBox();
                        const padding = 6;
                        box.setAttribute('x', String(bbox.x - padding));
                        box.setAttribute('y', String(bbox.y - padding));
                        box.setAttribute('width', String(bbox.width + padding * 2));
                        box.setAttribute('height', String(bbox.height + padding * 2));
                        box.setAttribute('display', 'inline');
                    }
                } else {
                    nameText.setAttribute('display', 'none');
                    const box = sliceBoxes[index];
                    if (box) {
                        box.setAttribute('display', 'none');
                    }
                }
            }
        });

        handlesGroup.innerHTML = '';
        boundaries.forEach((angle, index) => {
            const handleGroup = document.createElementNS(svgNS, 'g');
            handleGroup.setAttribute('data-handle-index', index);
            handleGroup.setAttribute('class', 'handle-group');

            // Compute tip position so the invisible hit zone lines up with the visual handle
            const tipPos = polarToCartesian(angle, radius + 6);

            const hitZone = document.createElementNS(svgNS, 'circle');
            hitZone.setAttribute('cx', String(tipPos.x));
            hitZone.setAttribute('cy', String(tipPos.y));
            // Larger radius for easier touch targeting (visual unchanged)
            hitZone.setAttribute('r', '40');
            hitZone.classList.add('handle-hit-zone');
            // ensure the hit zone carries the handle index for event lookup
            hitZone.setAttribute('data-handle-index', index);
            handleGroup.appendChild(hitZone);

            const handle = document.createElementNS(svgNS, 'polygon');
            handle.classList.add('handle');
            handle.setAttribute('points', createTrianglePoints(angle));
            handle.setAttribute('aria-label', 'Drag to adjust slice ratio');
            handle.setAttribute('role', 'slider');
            handle.setAttribute('tabindex', '-1');
            handle.setAttribute('data-handle-index', index);
            handleGroup.appendChild(handle);

            // Attach pointer handlers to the hit zone for larger interactive area
            hitZone.addEventListener('pointerdown', onPointerDown);
            handlesGroup.appendChild(handleGroup);
        });
    }

    function findHandleFromEvent(event) {
        let target = event.target;
        while (target && !target.classList.contains('handle-group')) {
            target = target.parentElement;
        }
        if (target && target.hasAttribute('data-handle-index')) {
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
