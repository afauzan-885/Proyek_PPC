<div>
    <div id="chart"></div>

    @push('scripts')
        <script>
            var options = {
                stroke: {
                    curve: 'smooth',
                },
                chart: {
                    type: 'line'

                },
                series: @json($series), // Gunakan data dari controller
                xaxis: {
                    // range: 2,
                    categories: @json($categories) // Gunakan categories dari controller

                }
            }

            var chart = new ApexCharts(document.querySelector("#chart"), options);

            chart.render();
        </script>
    @endpush
</div>
