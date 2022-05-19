{{--
    /**
     * Footer partial, injected in master layout
     *
     * @package Academy Management Software
     * @author DataTrix Team
     */
--}}
<!-- Main Footer -->
<footer id="dt-Footer" class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        {{--  Coding is our passion  --}}
        <strong><a :href="datatrixURL" target="_blank" v-text="datatrixMoto"></a></strong>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ \Carbon\Carbon::now()->year }}
        <a href="http://datatrixsoft.com">DataTrix Soft</a>.</strong>
    All rights reserved.
</footer>