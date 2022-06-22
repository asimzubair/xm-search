<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

<!-- Datepicker code started -->
<script>
    $('#start_date').datepicker({
        dateFormat: "yy-mm-dd"
    });
    $('#end_date').datepicker({
        dateFormat: "yy-mm-dd"
    });
</script>
<!-- Datepicker code ended -->

<!-- Form validation code started -->
<script>

/*$("#search_form").validate({
    rules: {
        company_symbol: "required",
        start_date: {
            required: true,
            before_or_equal: "#start_date",
            less_or_equal : "#end_date"
        },
        end_date: {
            required: true,
            before_or_equal: "#end_date",
            after_or_equal: "#start_date"
        },
        email: {
            required: true,
            email: true
        }
    }
});

jQuery.validator.addMethod("before_or_equal", function (value, element, params) {
    return new Date(value) <= new Date();
},  'Must be a date before or equal to today.');

jQuery.validator.addMethod("less_or_equal", function (value, element, params) {
    return new Date(value) <= new Date($(params).val());
},  'The start date must be a date before or equal to end date.');

jQuery.validator.addMethod("after_or_equal", function (value, element, params) {
    return new Date(value) >= new Date($(params).val());
},  'The end date must be a date after or equal to start date.');*/

</script>
<!-- Form validation code ended -->

<!-- Chart code started -->
@if(isset($dateRangeData))
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.css" integrity="sha512-72LrFm5Wau6YFp7GGd7+qQJYkzRKj5UMQZ4aFuEo3WcRzO0xyAkVjK3NEw8wXjEsEG/skqvXKR5+VgOuzuqPtA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js" integrity="sha512-yhdujT21BI/kqk9gcupTh4jMwqLhb+gc6Ytgs4cL0BJjXW+Jo9QyllqLbuluI0cBHqV4XsR7US3lemEGjogQ0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var dateRangeData = @json( array_reverse($dateRangeData, false) );
        
        var dates = [];
        var open = [];
        var close = [];
        dateRangeData.forEach(function(obj) 
        { 
            dates.push(obj.date);
            open.push(obj.open);
            close.push(obj.close);
        });

        var options = {
            chart: {
                height: 380,
                type: "line"
            },
            series: [
                {
                    name: "Open Price",
                    type: "column",
                    data: open
                },
                {
                    name: "Close Price",
                    type: "column",
                    data: close
                }
            ],
            stroke: {
                width: [0, 4],
                curve: 'smooth'
            },
            title: {
                text: "Open and Close prices"
            },
            labels: dates,
            xaxis: {
                type: "datetime"
            },
            yaxis: [
                {
                    title: {
                        text: "Open Price"
                    }
                },
                {
                    opposite: true,
                    title: {
                        text: "Close Price"
                    }
                }
            ]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
    </script>
@endif
<!-- Chart code ended -->