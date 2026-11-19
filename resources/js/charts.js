/**
 * Small, dependency-free SVG chart used by the dashboard.
 * It is bundled by Vite together with the rest of the frontend code.
 */

/**
 * @param {number} value
 * @returns {string}
 */
function formatCompact(value) {
    if (value >= 1000000) {
        return `${(value / 1000000).toFixed(1).replace('.', ',')} M`;
    }

    if (value >= 1000) {
        return `${Math.round(value / 1000)} mil`;
    }

    return new Intl.NumberFormat('es-CO', { maximumFractionDigits: 0 }).format(value);
}

/**
 * @param {number} value
 * @returns {number}
 */
function roundScale(value) {
    if (value <= 0) {
        return 1000;
    }

    const magnitude = 10 ** Math.floor(Math.log10(value));
    const scaled = value / magnitude;
    const step = scaled <= 1 ? 1 : scaled <= 2 ? 2 : scaled <= 5 ? 5 : 10;

    return step * magnitude;
}

/**
 * @param {string} value
 * @returns {string}
 */
function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
    })[character]);
}

/**
 * @param {{ etiqueta: string, ingresos: number, gastos: number }[]} series
 * @returns {string}
 */
function buildSvg(series) {
    const width = 720;
    const height = 232;
    const padding = { top: 14, right: 14, bottom: 28, left: 50 };
    const innerWidth = width - padding.left - padding.right;
    const innerHeight = height - padding.top - padding.bottom;
    const baseline = padding.top + innerHeight;
    const highest = roundScale(Math.max(1, ...series.flatMap((point) => [point.ingresos, point.gastos])));

    const x = (index) => series.length === 1
        ? padding.left + innerWidth / 2
        : padding.left + (index * innerWidth) / (series.length - 1);

    const y = (value) => baseline - (value / highest) * innerHeight;

    const grid = [0, 0.25, 0.5, 0.75, 1].map((ratio) => {
        const position = baseline - ratio * innerHeight;
        const label = formatCompact(highest * ratio);

        return `<line class="chart-grid-line" x1="${padding.left}" y1="${position.toFixed(1)}" x2="${width - padding.right}" y2="${position.toFixed(1)}" stroke-width="1" />
                <text class="chart-axis-label" x="${padding.left - 10}" y="${(position + 3).toFixed(1)}" text-anchor="end">${escapeHtml(label)}</text>`;
    }).join('');

    const labels = series.map((point, index) => (
        `<text class="chart-axis-label" x="${x(index).toFixed(1)}" y="${height - 7}" text-anchor="middle">${escapeHtml(point.etiqueta)}</text>`
    )).join('');

    const line = (key) => series
        .map((point, index) => `${index === 0 ? 'M' : 'L'}${x(index).toFixed(1)} ${y(point[key]).toFixed(1)}`)
        .join(' ');

    return `<svg viewBox="0 0 ${width} ${height}" class="h-full w-full" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        ${grid}
        <path class="chart-line chart-line-income" d="${line('ingresos')}" vector-effect="non-scaling-stroke" />
        <path class="chart-line chart-line-expense" d="${line('gastos')}" vector-effect="non-scaling-stroke" />
        ${labels}
    </svg>`;
}

/**
 * Renders the cashflow chart into every element marked with data-cashflow-chart.
 */
export function initCashflowChart() {
    document.querySelectorAll('[data-cashflow-chart]').forEach((host) => {
        let series;

        try {
            series = JSON.parse(host.dataset.series || '[]');
        } catch (error) {
            return;
        }

        if (!Array.isArray(series) || series.length === 0) {
            return;
        }

        host.innerHTML = buildSvg(series);
        host.setAttribute('role', 'img');
        host.setAttribute('aria-label', 'Evolución mensual de ingresos y gastos en los últimos seis meses.');
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCashflowChart);
} else {
    initCashflowChart();
}
