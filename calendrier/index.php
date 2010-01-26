
<script language="javascript">
function calendrierPopup(url, largeur, hauteur) {
	var top=(screen.height-hauteur)/2;
	var left=(screen.width-largeur)/2;
	var fen = window.open(""+url+"","popup","top="+top+", left="+left+", toolbar=0, location=0, directories=0, status=1, scrollbars=1, resizable=1, copyhistory=0, menuBar=0, width="+largeur+", height="+hauteur+"");
	if (self.focus) {
		fen.focus();
	}
}
</script>
<?php 
$url_relative="..";

                           require_once '$url_relative/calendrier/calendrier.php';
                           $params['link_before_date']=1;
                           $params['link_after_date']=1;
                           $params['show_day']=1;
                           $params['cell_width']=150;
                           $params['cell_height']=100;
                           $params['short_day_name']=0;
                           $params['day_mode']=0;
echo calendar();
                    ?> 