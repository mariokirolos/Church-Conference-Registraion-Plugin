<div class="wrap">
	<h1>Registraion Forms</h1> <form><input type="submit" name="total_conferences_report" class="exportBTN" value="Export CSV" /></form>
</div>

<table id="registraionTable">
	<thead>
		<tr>
			<th>#</th>
			<th>Conference</th>
			<th>Total Number of Rooms</th>
			<th>Paid Amount</th>
			<th>Remaining Amount</th>
			<th>Export</th>
		</tr>
	</thead>
	<tbody>
		<?php 


		$conferences = $this->getConferences();

			for($i = 0 ; $i < count($conferences) ; $i++ ){
				?>
			<tr>
				<td><?php print $i+1; ?></td>
				<td><?php print $conferences[$i]['name'];?></td>
				<td><?php print $conferences[$i]['count'];?></td>
				<td>$<?php print $conferences[$i]['totalPaid'];?></td>
				<td>$<?php print $conferences[$i]['totalRemaining'];?></td>
				<td>

				
				<form action="" method="GET">
					<input type="hidden" name="export_pending_rooms" value="<?php print $conferences[$i]['term_taxonomy_id'];?>" />
					<input type="submit" value="Pending Rooms" />
				</form>


				<form action="" method="GET">
					<input type="hidden" name="export_conference" value="<?php print $conferences[$i]['term_taxonomy_id'];?>" />
					<input type="submit" value="Export CSV" />
				</form>

				</td>
			</tr>
				<?php
			}
		?>
	</tbody>
</table>