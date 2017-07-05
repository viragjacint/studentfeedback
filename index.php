<?php
if (!array_key_exists('u',$_REQUEST)){
include 'welcome.php';
exit();
}
$con = new mysqli('localhost','40270622','mC/Y73Hi','40270622');
if ($con->connect_error){
  die('Connection failure');
}
$sql = "select SPR_FNM1,SPR_SURN from INS_SPR where SPR_CODE=?";
$stmt = $con->prepare($sql)
  or die($con->error);
$stmt->bind_param('s',$_REQUEST['u'])
  or die('Bind error');
$stmt->execute()
  or die('Execute error');
$cur = $stmt->get_result();
if (!($row = $cur->fetch_array())){
  header('Location: index.php?error=1'); 
  exit();
}
$stmt->close();
#Get a list of modules
$sql = "select CAM_SMO.MOD_CODE,MOD_NAME,INS_MOD.PRS_CODE,PRS_FNM1,PRS_SURN
  from CAM_SMO join INS_MOD ON (CAM_SMO.MOD_CODE=INS_MOD.MOD_CODE)
		  left join INS_PRS ON (INS_MOD.PRS_CODE=INS_PRS.PRS_CODE)
 where SPR_CODE=? AND AYR_CODE='2016/7' AND PSL_CODE='TR1'
";
$stmt = $con->prepare($sql)
  or die("Prepare failed: $con->errno :".$con->error);
$stmt->bind_param('s',$_REQUEST['u'])
  or die('Bind error');
$stmt->execute()
  or die('Execute error');
$cur = $stmt->get_result();
?>
<html lang="en">
<?php include 'head.php'; ?>
<body>

	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Online Module Feedback</a>
            </div>            
        </div>
        <!-- /.container -->
    </nav>
	
	<div class="container" style="padding-top:50px;">
		<div class="row">
			<div class="col-md-12">
			<h1><span style="font-size:30px;"><i class="fa fa-graduation-cap" aria-hidden="true" title="Graduation cap"></i></span> Welcome student: <?php echo $row[0].' '. $row[1];?></h1>
				<p>Please take a few minutes to help us by telling us about your experience of the module.
				Your feedback will help to improve the quality of our teaching, learning and assesment. 
				Please answer all questions that apply by marking the appropiate selecting the option.<br>
				<b>Key: DA</b>= Definitely Agree, <b>MA</b>= Mostly Agree, <b>N</b>= Neither Agree or Disagree,
				<b>MD</b> = Mostly Disagree,<b> DD </b>= Definitely Disagree</p>
				<form action='store_fb.php'>									
						<?php 
						#loop through the modules
						while ($row = $cur->fetch_row()){
							print "<h2>Please answer questions about <i class='fa fa-book' aria-hidden='true' title='book ilustration'></i> $row[0]</h2>";					
							#goes through the catgories
							for ($x = 1; $x <= 4; $x++) {								
								$sql2 = "SELECT INS_QUE.QUE_CODE,CAT_CODE, QUE_NAME,QUE_TEXT,RES_VALU
								FROM INS_QUE
								JOIN INS_RES ON (INS_QUE.QUE_CODE = INS_RES.QUE_CODE)
								WHERE CAT_CODE=? AND SPR_CODE = ? AND MOD_CODE = ?";
								
								$stmt2 = $con->prepare($sql2)
								or die("Prepare failed: $con->errno :".$con->error);
								$stmt2->bind_param('iss', $x, $_REQUEST['u'], $row[0])
								or die('Bind error');
								$stmt2->execute()
								or die('Execute error');
								$cur2 = $stmt2->get_result();		
								?>
								<div class="table-responsive">
								<table class='table table-striped table-bordered'>
								<?php
								#prints the question catgories
								switch ($x) {
								case 1:
									echo "<caption><h3>Learning and Teaching</h3></caption>";				
									break;				
								case 2:			
									echo "<caption><h3>Assessment and Feedback</h3></caption>";
									break;
								case 3:
									echo "<caption><h3>Learning Resources</h3></caption>";
									break;
								case 4:
									echo "<caption><h3>Overall</h3></caption>";
									break;
								default:
									echo "";
								}
								?>								
								<thead>
								  <tr>
									<th>Q No.</th>
									<th>Question</th>
									<th>DA</th>
									<th>MA</th>
									<th>N</th>
									<th>MD</th>
									<th>SD</th>
								  </tr>
								</thead>
								<tbody>
								<?php
								#prints the form
								while ($row2 = $cur2->fetch_row()){									
									echo "<tr><td>" . $row2[0] . ' </td><td> ' . $row2[2] . ' </td>';			
									?>						
									<td><input type='radio' name='<?php echo $row[0].'_Q'.$row2[0];?>' value='5' <?php if($row2[4] == 5) echo 'checked'?>></td>
									<td><input type='radio' name='<?php echo $row[0].'_Q'.$row2[0];?>' value='4' <?php if($row2[4] == 4) echo 'checked'?>></td>
									<td><input type='radio' name='<?php echo $row[0].'_Q'.$row2[0];?>' value='3' <?php if($row2[4] == 3) echo 'checked'?>></td>
									<td><input type='radio' name='<?php echo $row[0].'_Q'.$row2[0];?>' value='2' <?php if($row2[4] == 2) echo 'checked'?>></td>
									<td><input type='radio' name='<?php echo $row[0].'_Q'.$row2[0];?>' value='1' <?php if($row2[4] == 1) echo 'checked'?>></td>
									</tr>	
									
									<?php
									
								}		
								?>
								</tbody>
								</table>
								</div>
								<?php
							} 
							
						}
						?>
						
										
					<input type='hidden' name='u' value='<?php echo $_REQUEST['u'];?>'>
					<input class="btn btn-primary btn-md" type='submit'>
				</form>			
			</div>
		</div>
	</div>
</body>
</html>
