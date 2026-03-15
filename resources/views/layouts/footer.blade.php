 <!-- footer content -->
 <footer style="margin-top:auto">
    <div class="pull-right">
        Developed by Softguide Team Member
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>
<!-- Custom Theme Scripts -->
<script src="{{ URL::asset("assets/js/custom.js") }}"></script>
    @if (session()->has('success_message'))
        <script>
            $(document).ready(function () {
                new PNotify({
                    title   : 'Congrat!',
                    text    : '{{ session()->get('success_message') }}',
                    type    : 'success',
                    styling : 'bootstrap3'
                });
            })
        </script>
    @endif
</body>
</html>