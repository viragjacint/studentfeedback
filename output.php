<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Jacint Virag">
    <title>Online Student Module Feedback Reporting System</title>
	<!-- Bootstrap Core JavaScript -->
	<!-- jQuery Version 3.2.1 -->
	<!-- Custom Font -->
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
	<link rel="stylesheet" href="https://bootswatch.com/simplex/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
    <!-- Custom CSS -->	
	
	

</head>
<style>

td {
	font-size:14px;
}

</style>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Module Feedback System</h1>
				<p>Please select a module from the dropdown list</p>		
				<form>
				<div class="input-group">
				<?php
					$con = new mysqli('localhost','40270622','mC/Y73Hi','40270622');
					if ($con->connect_error){
					  die('Connection failure');
					}			
					$sql = "SELECT MOD_CODE FROM INS_MOD";
					$query = mysqli_query($con, $sql);
					?>
					<select name='MOD_CODE' id='MOD_CODE' class='form-control'>
					<?php
					
					while($row = mysqli_fetch_array($query)) {
						#sets dropdown values by the mod_code or uses the first one as default
						?>						
						<option value='<?php echo $row['0']; ?>' <?php
						if(isset($_GET["MOD_CODE"])){if ($row['0'] == $_GET["MOD_CODE"]) {echo "selected='selected'";}} ?>><?php echo $row['0']; ?></option>
					<?php
					}
					?>
					</select>			
					<span class="input-group-addon">
						<button type="submit" id="go">Show</button>
					</span>
				</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">			
				<h3>Radar chart</h3>
				<canvas id="myChart" width="300" height="300"></canvas>
				<script>
				$(function(){			
						$.ajax({url: "radar.php", data: {MOD_CODE:$('#MOD_CODE option:selected').text()}, dataType: 'json', success: function(d){
							var data = {labels: [], datasets: [{label: $('#MOD_CODE option:selected').text() + ' results', data: [],}]};
							for (var i=0; i <d.length; i++) {
								data.labels.push(d[i][0]);
								data.datasets[0].data.push(parseFloat(d[i][1]));
							}
						console.log(data);
						var ctx = document.getElementById("myChart");
						var myChart = new Chart(ctx, {
							type: 'radar',
							data: data,
							options: {
								responsive: true,
								scale: { ticks: { beginAtZero: true }}}});
						}});
						
				});
				</script>
			</div>
		
			<?php
			$mc = 'CSN08101';
				if(isset($_GET["MOD_CODE"])){ $mc = $_GET["MOD_CODE"];}
			?>
			<div class="col-md-8">	
				<h3>Output Scores For Module <?php echo $mc ?> </h3>
				<div class="table-responsive">
					<table class="table table-striped">
					<?php
					$con = new mysqli('localhost','40270622','mC/Y73Hi','40270622');
					if ($con->connect_error){
					  die('Connection failure');
					}
					
					$sql = "SELECT INS_RES.QUE_CODE, QUE_TEXT,CAT_SNAM,
						   ROUND(100*SUM(FLOOR(RES_VALU/4))/COUNT(1)) as score, COUNT(1)
						   FROM INS_RES JOIN INS_QUE ON INS_RES.QUE_CODE=INS_QUE.QUE_CODE
						   JOIN INS_CAT ON INS_QUE.CAT_CODE=INS_CAT.CAT_CODE
							WHERE INS_RES.MOD_CODE='$mc'
						   AND INS_RES.AYR_CODE='2016/7'
						   AND INS_RES.PSL_CODE='TR1'
							GROUP BY QUE_CODE,QUE_TEXT,CAT_SNAM";
					$query = mysqli_query($con, $sql);						
					?>
					<thead>
						<tr>							
							<th>QNo.</th>
							<th>Question</th>
							<th>Cat</th>
							<th>%Agree</th>
							<th>#Responses</th>
						</tr>
					</thead>
					<tbody>
					<?php
					while($row = mysqli_fetch_array($query)) {
						
					echo "<tr>								
								<td>".$row[0] ."</td>
								<td>".$row[1] ."</td>
								<td>".$row[2] ."</td>
								<td>".$row[3] ."%</td>
								<td>".$row[4] ."</td>
						</tr>";
					
					}
					?>				
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>



