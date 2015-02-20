<div class="row">
	<div class="col-sm-12">
		<table class="table">
			<tr>
				<td><div<?php
					if($CURRENT_PAGE_TYPE == 'Collections'){
						echo ' class="active"';
					}
					?>>Collections</div>
				</td>
				<td class="tab-sep"></td>
				<td><div<?php
					if($CURRENT_PAGE_TYPE == 'Clothes'){
						echo ' class="active"';
					}
					?>>Outfits</div>
				</td>
				<td class="tab-sep"></td>
				<td><div<?php
					if($CURRENT_PAGE_TYPE == 'Frame'){
						echo ' class="active"';
					}
					?>>Frames</div>
				</td>
				<td class="tab-sep"></td>
				<td><div<?php
					if($CURRENT_PAGE_TYPE == 'Upload'){
						echo ' class="active"';
					}
					?>>Photo Upload</div>
				</td>
			</tr>
		</table>
	</div>
</div>