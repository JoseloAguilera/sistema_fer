<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
.midnight-blue{
    background:#2c3e50;
    padding: 4px 4px 4px;
    color:white;
    font-weight:bold;
    font-size:12px;
}
.silver{
    background:white;
    padding: 3px 4px 3px;
}
.clouds{
    background:#ecf0f1;
    padding: 3px 4px 3px;
}
.border-top{
    border-top: solid 1px #bdc3c7;

}
.border-left{
    border-left: solid 1px #bdc3c7;
}
.border-right{
    border-right: solid 1px #bdc3c7;
}
.border-bottom{
    border-bottom: solid 1px #bdc3c7;
}
table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
}
-->
</style>
<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
     <page_footer>
        <table class="page_footer">
            <tr>

                <td style="width: 50%; text-align: left">
                    P&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 50%; text-align: right">
                    &copy; <?echo "obedalvarado.pw ";
echo $anio = date('Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>
    <table cellspacing="0" style="width: 100%;">
        <tr>

            <td style="width: 25%; color: #444444;">
                <img style="width: 100%;" src="../<?php echo get_row('perfil', 'logo_url', 'id_perfil', 1); ?>" alt="Logo"><br>

            </td>
			<td style="width: 75%;text-align:right">
			COTIZACION Nº <?echo $numero_cotizacion; ?>
			</td>

        </tr>
    </table>
    <br>
     <table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">
		<tr>
		<td style="width:50%; "><strong>Dirección:</strong> <br>San Miguel, El Salvador C.A.<br> Teléfono.: (503)2222-2222</td>

		</tr>
	</table>

	<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
		<tr>
			<td style="width: 100%;text-align:right">
			Fecha: <?echo date("d-m-Y"); ?>
			</td>
		</tr>
	</table>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>

            <td style="width:15%; ">Atención:</td>
            <td style="width:50%"><?echo $atencion; ?> </td>
			<td style="width:15%;text-align:right"> Teléfono:</td>
			<td style="width:20%">&nbsp;<?echo $tel1; ?> </td>
        </tr>
        <tr>

            <td style="width:15%; ">Empresa:</td>
            <td style="width:50%"><?echo $empresa; ?></td>
			<td style="width:15%;text-align:right"> Teléfono:</td>
			<td style="width:20%">&nbsp; <?echo $tel2; ?> </td>
        </tr>
        <tr>

            <td style="width:15%; ">Email:</td>
            <td style="width:50%"><?echo $email; ?></td>
        </tr>

    </table>

        <table cellspacing="0" style="width: 100%; text-align: left;font-size: 11pt">
        <tr>
             <td style="width:100%; ">A continuación Presentamos nuestra oferta que esperamos sea de su conformidad.</td>
        </tr>
    </table>


</page>
