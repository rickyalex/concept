<style type="text/css" media="print">
        @page 
        {
            size: auto;   /* auto is the current printer page size */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }

        body 
        {
            background-color:#FFFFFF;
            margin: 0px;  /* the margin on the content before printing */
       }
    </style>
<section class="content-header" style="margin-left:10px;">
	<div id="checkout_header" class="row">
		<label>Header</label>
	</div>
    <ol class="breadcrumb">
</section>
<section class="content">
	<div id="checkout_content" class='row' style="margin-left:10px;">
		<table>
			<tr>
				<td style="text-align:center;width:120px;">Item</td>
				<td style="text-align:center">Qty</td>
				<td style="text-align:center">Price</td>
				<td style="text-align:center">Subtotal</td>
			</tr>
			<?php 
			$Subtotal = 0;
			for($i=0;$i<count($product);$i++){ 
				$Subtotal = $Subtotal + $product[$i]['subtotal'];
				if(trim($product[$i]['tipe']) == 'NP'){
				?>
					<tr>
						<td style="text-align:left"><?php echo trim($product[$i]['product']); ?></td>
						<td style="text-align:center"><?php echo $product[$i]['qty']; ?></td>
						<td style="text-align:right"><?php echo number_format($product[$i]['price'],0,",","."); ?></td>
						<td style="text-align:right"><?php echo number_format($product[$i]['subtotal'],0,",","."); ?></td>
					</tr>
			 <?php }else{
			 		?>
			 		<tr>
						<td style="text-align:left"><?php echo trim($product[$i]['product']); ?></td>
						<td style="text-align:center"><?php echo $product[$i]['qty']; ?></td>
						<td style="text-align:right"></td>
						<td style="text-align:right"></td>
					</tr>
			 		<?php
			 			$arr = $this->qms_model->getPackageDetail($product[$i]['product_id']);
						$Discount = $this->qms_model->getDiscount($product[$i]['product_id']);
						foreach($arr as $key => $value){
							$arr[$key]['product'] = $this->qms_model->getProductName2($arr[$key]['product_id']);
							$Price = $this->qms_model->getProductPrice($arr[$key]['product_id']);
							$Qty = ($product[$i]['qty'] * $arr[$key]['qty']);
							?>
						<tr>
							<td style="text-align:left"><?php echo trim($arr[$key]['product']); ?></td>
							<td style="text-align:center"><?php echo $Qty; ?></td>
							<td style="text-align:right"><?php echo number_format($Price,0,",","."); ?></td>
							<td style="text-align:right"><?php echo number_format($Qty * $Price,0,",","."); ?></td>
						</tr>
							<?php
						}
						?>
					<tr>
						<td colspan="3" style="text-align:right">Package Discount (<?php echo $Discount.'%) : '; ?></td>
						<td style="text-align:right"><?php echo number_format($product[$i]['subtotal'],0,",","."); ?></td>
					</tr>
						<?php
			 		}
			 	} ?>
		 	<tr>
				<td colspan="3" style="text-align:right">TOTAL : </td>
				<td style="text-align:right"><?php echo number_format($Subtotal,0,",","."); ?></td>
			</tr>
		 	<tr>
				<td colspan="3" style="text-align:right">CASH : </td>
				<td style="text-align:right"><?php echo number_format($cash,0,",","."); ?></td>
			</tr>
		 	<tr>
				<td colspan="3" style="text-align:right">CHANGE : </td>
				<td style="text-align:right"><?php echo number_format($return,0,",","."); ?></td>
			</tr>
		</table>
	</div>
	
</section>
<script>
  window.print();
</script>