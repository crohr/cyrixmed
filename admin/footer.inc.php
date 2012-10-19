			</td></tr>
		</table>
</td>
</tr>
</table>
<?php
if (isset($insertIntoFoot)) {
	echo $insertIntoFoot;
}
?>
<div style="text-align:center;font-style:Verdana;font-size:10px">
<?php
$temps_fin=microtime();
$temps_chargement=$temps_fin-$temps_debut;
echo "Page générée en $temps_chargement secondes<br>";
?>
</div>
</body></html>