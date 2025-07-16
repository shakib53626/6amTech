import { ref } from "vue";

export function useStatisticsChart() {
    const options = [
        { value: 'optionOne', label: 'Monthly' },
        { value: 'optionTwo', label: 'Quarterly' },
        { value: 'optionThree', label: 'Annually' },
    ]

    const selected = ref('optionOne')

    const series = ref([
        {
            name: 'Sales',
            data: [180, 190, 170, 160, 175, 165, 170, 205, 230, 210, 240, 235],
        },
        {
            name: 'Revenue',
            data: [40, 30, 50, 40, 55, 40, 70, 100, 110, 120, 150, 140],
        },
    ])

    const chartOptions = ref({
        legend: {
            show           : false,
            position       : 'top',
            horizontalAlign: 'left',
        },

        colors: ['#465FFF', '#9CB9FF'],

        chart: {
            fontFamily: 'Outfit, sans-serif',
            type      : 'area',
            toolbar   : { show: false },
        },

        fill: {
            gradient: {
                enabled    : true,
                opacityFrom: 0.55,
                opacityTo  : 0,
            },
        },

        stroke: {
            curve: 'straight',
            width: [2, 2],
        },

        markers: {
            size: 0,
        },

        labels: {
            show: false,
            position: 'top',
        },

        grid: {
            xaxis: {
                lines: { show: false },
            },
            yaxis: {
                lines: { show: true },
            },
        },

        dataLabels: { enabled: false },

        tooltip: {
            x: { format: 'dd MMM yyyy' },
        },

        xaxis: {
            type      : 'category',
            categories: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ],
            axisBorder: { show: false },
            axisTicks : { show: false },
            tooltip   : { enabled: false },
        },
        yaxis: {
            title: {
                style: { fontSize: '0px' },
            },
        },
    })

  return { selected, options, series, chartOptions };
}
