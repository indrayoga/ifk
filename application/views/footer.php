            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <!-- #push do not remove -->
            <div id="push"></div>
            <!-- /#push -->
        </div>
        <!-- END WRAP -->

        <div class="clearfix"></div>

        <!-- BEGIN FOOTER -->

        <footer class="navbar-default navbar-fixed-bottom">
            <div id="footer">
                <p>2014 © Planet IT</p>
            </div>            
        </footer>        
<?php

   // include('/chat/samplea.php');
?>
        <!-- END FOOTER -->

        <!-- #helpModal -->
        <div id="helpModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="helpModalLabel"><i class="icon-external-link"></i> Help</h3>
            </div>
            <div class="modal-body">
                <p>
                 
                </p>
            </div>
            <div class="modal-footer">

                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- /#helpModal -->
    </body>
</html>
		
<script type="text/javascript">
$(document).ready(function(){
    if(($('.with-tooltip').siblings().attr('class')=='control-label wajib')){
       // console.log($('.with-tooltip').children().hasClass('input-tooltip'));
        $('.with-tooltip *').each(function(){
            if($(this).hasClass('input-tooltip') && $(this).parent().siblings().attr('class')=='control-label wajib' ){
                $(this).attr("data-original-title", $(this).attr("data-original-title") + " Wajib di Isi");
            }
        })
    }
});
</script>
<style type="text/css">
footer.navbar-default.navbar-fixed-bottom
 {
      background:#F5F5F5;
      color:black;
      padding:1em 0;
 }
 footer.navbar-default.navbar-fixed-bottom p
 {
      margin:0;
 }
</style>