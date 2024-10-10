<div>
    <div class="card-header text-center border-0">
        <h4 class="card-title">Grafik Pesanan</h4>
        <div id="chart" style="max-height: 360px;"></div>
    </div>

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
                    // range: 3,
                    categories: @json($categories) // Gunakan categories dari controller

                }
            }

            var chart = new ApexCharts(document.querySelector("#chart"), options);

            chart.render();
        </script>
    @endpush
</div>
