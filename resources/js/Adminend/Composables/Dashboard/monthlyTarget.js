export function useMonthlyTarget() {
    const menuItems = [
        { label: 'View More', onClick: () => console.log('View More clicked') },
        { label: 'Delete',    onClick: () => console.log('Delete clicked') },
    ]

    const chartOptions = {
        colors: ['#465FFF'],

        chart: {
            fontFamily: 'Outfit, sans-serif',
            sparkline: {
                enabled: true,
            },
        },

        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                hollow: {
                    size: '80%',
                },

                track: {
                    background: '#E4E7EC',
                    strokeWidth: '100%',
                    margin: 5,
                },

                dataLabels: {
                    name: {
                        show: false,
                    },

                    value: {
                        fontSize: '36px',
                        fontWeight: '600',
                        offsetY: -30,
                        color: '#1D2939',
                        formatter: function (val) {
                            return val.toFixed(2) + '%'
                        },
                    },
                },

            },
        },

        fill: {
            type: 'solid',
            colors: ['#465FFF'],
        },

        stroke: {
            lineCap: 'round',
        },

        labels: ['Progress'],
        }

    return { menuItems, chartOptions }
}
