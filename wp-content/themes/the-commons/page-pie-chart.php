<?php
/*
Template Name: Pie Chart Key Page
*/
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'pie-chart-page' ); ?>>
    <main class="pie-chart-shell">
        <section class="pie-chart-content" aria-label="Draggable pie chart interface">
            <h1>Pie Chart</h1>
            <p class="pie-chart-instruction">Drag the handles around the edge to change the slice ratios. Tap reset to restore equal thirds.</p>
            <div class="pie-chart-svg-wrapper">
                <svg id="pieChartSvg" viewBox="0 0 320 320" aria-label="Draggable pie chart" role="img">
                    <g transform="translate(160 160)">
                        <path class="slice slice-0" />
                        <path class="slice slice-1" />
                        <path class="slice slice-2" />
                        <g class="slice-labels">
                            <text class="slice-label slice-label-0"></text>
                            <text class="slice-label slice-label-1"></text>
                            <text class="slice-label slice-label-2"></text>
                        </g>
                        <g class="handles"></g>
                    </g>
                </svg>
            </div>
            <button id="pieChartReset" type="button">Reset</button>
        </section>
    </main>
    <?php wp_footer(); ?>
</body>
</html>
