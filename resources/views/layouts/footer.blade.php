<a style="bottom: 0; right:10px;" class="position-fixed m-3 btn btn-outline-dark" href="#"><i class="fa fa-arrow-up"
        aria-hidden="true"></i>
</a>




<div class="p-3 bg-dark d-flex flex-column align-items-center justify-content-center mt-3">
    <a href="{{url('post')}}">
        <img src="https://img.icons8.com/carbon-copy/70/000000/instagram.png" style="filter: invert(1);" />
    </a>
    <p class="text-white">شبكة انستغرام بيغاسوس</p>
</div>



<!-- Bootstrap core JavaScript
  ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script>
    window.jQuery || document.write('<script src="./assets/js/vendor/jquery-slim.min.js"><\/script>')

</script>
<script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/holder.min.js') }}"></script>

<!-- Import typeahead.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->

<!-- Import typeahead.js -->
<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        var bloodhound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '{{ url('search') }}?searchname=%QUERY%', //'/user/find?q=%QUERY%',
                wildcard: '%QUERY%'
            },
        });

        $('#search').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'users',
            source: bloodhound,
            display: function(data) {
                return data.name //Input value to be set when you select a suggestion. 
            },
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item" style="direction: rtl; text-align: right; ">لا يوجد نتائج بحث مطابقة</div></div>'
                ],
                header: [
                    '<div class="list-group search-results-dropdown">'
                ],
                suggestion: function(data) {
                    return '<div style="font-weight:normal;direction: rtl; text-align: right; width:100%" class="list-group-item"> <a href="{{ url('user_info') }}/' +
                        data.id + '"> <img src="{{ asset('images/avatar') }}/' + data.avatar +
                        '" style=" margin-left: 2%; " width="35px" height="35px"/>' + data
                        .first_name + ' ' + data.last_name + '</a></div></div>'
                }
            }
        });
    });

</script>
</body>
