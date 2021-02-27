<html>

<head>
	<title>Create Job</title>
	<link rel="stylesheet" href="jquery-ui.css">
	<link rel="stylesheet" href="bootstrap.min.css" />
	<script src="jquery.min.js"></script>
	<script src="jquery-ui.js"></script>
	<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
	<style>
		#user_form {
			display: flex;
			/* align-items: center; */
			/* justify-content:flex-start; */
			flex-direction: column;
		}

		footer {
			position: fixed;
			bottom: 0;
		}

		header {
			height: 8vh;
			background-color:#3F495E;
			color: white;
			padding: 1rem;
		}
		header img{
			width: 2rem;
			height: 1rem;
		}
		.main{
			display: flex;
			margin:  0;
			width: 100%;
			height: 85vh;
		}
		.links{
			width: 20%;
			background-color:#e2e8f0;
			padding: 0 2rem;
			display: flex;
			justify-content:flex-start;
			align-items: center;
			flex-direction: column;
		}
		.links a{
			font-size: larger;
		}
		.content{
			width: 80%;
			padding: 2rem;
		}
		.links div{
			margin: 2rem;

		}
	</style>
</head>

<body>
	<header>
		<h2 style="font-size: 3rem;">Rojgar Bharat</h2>
	</header>
	<div class="main">
		<div class="links" >
			<div>
				<a href="../index.php">Dashboard</a>
			</div>
			<div>
				<a href="./modals.php">Job Posted</a>
			</div>
	</div>
	<div class="content">
		<div class="container">
			<div align="left" style="margin-bottom:5px;display: flex;
			flex-direction: column;
			align-items: flex-start;
			justify-content: space-around;height: 20%;border: 1px solid gray;
			padding: 2rem; border-radius: 0.5rem;width: 50%; height: auto;" >
				<div style="margin: 2rem 0;"><h2 style="font-size: 2rem;"> Post a new Job</h2></div>
				<button type="button" name="add" id="add" style="padding: 1rem;" class="btn btn-success btn-xs">Create Job</button>
			</div>
			<div class="table-responsive" id="user_data">

			</div>
			<br />
		</div>

		<div id="user_dialog" title="Add Data">
			<form method="post" id="user_form">
				<div style="display: flex;">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="Title" id="Title" class="form-control" />
						<span id="error_title" class="text-danger"></span>
					</div>
					<div class="form-group">
						<label>Day</label>
						<input type="number" name="Day" id="Day" class="form-control" />
						<span id="error_day" class="text-danger"></span>
					</div>
				</div>
				<div class="form-group">
					<label>Salary</label>
					<input type="number" name="Salary" id="Salary" class="form-control" />
					<!-- <span id="error_day" class="text-danger"></span> -->
				</div>
				<div style="display: flex;">
					<div class="form-group">
						<label>State</label>
						<input type="text" name="State" id="State" class="form-control" />
						<!-- <span id="error_day" class="text-danger"></span> -->
					</div>
					<div class="form-group">
						<label>City</label>
						<input type="text" name="City" id="City" class="form-control" />
						<!-- <span id="error_day" class="text-danger"></span> -->
					</div>
					<div class="form-group">
						<label>Zip</label>
						<input type="text" name="Zip" id="Zip" class="form-control" />
						<!-- <span id="error_day" class="text-danger"></span> -->
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
				</div>
			</form>
		</div>

		<div id="action_alert" title="Action">

		</div>

		<div id="delete_confirmation" title="Confirmation">
			<p>Are you sure you want to Delete this job?</p>
		</div>
	</div>
</div>
<footer style="background-color:#3F495E ;width: 100%;height: 5vh ;color: white;display: flex;align-items: center;">
	<h2 style="margin: 0 1 rem;">All Copyrights-@Rojgar Bharat</h2>
</footer>
	

</body>

</html>




<script>
	$(document).ready(function () {

		load_data();

		function load_data() {
			$.ajax({
				url: "fetch.php",
				method: "POST",
				success: function (data) {
					$('#user_data').html(data);
				}
			});
		}

		$("#user_dialog").dialog({
			autoOpen: false,
			width: 400
		});

		$('#add').click(function () {
			$('#user_dialog').attr('title', 'Add Data');
			$('#action').val('insert');
			$('#form_action').val('Insert');
			$('#user_form')[0].reset();
			$('#form_action').attr('disabled', false);
			$("#user_dialog").dialog('open');
		});

		$('#user_form').on('submit', function (event) {
			event.preventDefault();
			var error_title = '';
			var error_day = '';
			if ($('#Title').val() == '') {
				error_title = 'Title is required';
				$('#error_title').text(error_title);
				$('#Title').css('border-color', '#cc0000');
			}
			else {
				error_title = '';
				$('#error_title').text(error_title);
				$('#Title').css('border-color', '');
			}
			if ($('#day').val() == '') {
				error_day = 'Day is required';
				$('#error_day').text(error_day);
				$('#day').css('border-color', '#cc0000');
			}
			else {
				error_day = '';
				$('#error_day').text(error_day);
				$('#day').css('border-color', '');
			}

			if (error_title != '' || error_day != '') {
				return false;
			}
			else {
				$('#form_action').attr('disabled', 'disabled');
				var form_data = $(this).serialize();
				$.ajax({
					url: "action.php",
					method: "POST",
					data: form_data,
					success: function (data) {
						$('#user_dialog').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
						$('#form_action').attr('disabled', false);
					}
				});
			}

		});

		$('#action_alert').dialog({
			autoOpen: false
		});

		$(document).on('click', '.edit', function () {
			var id = $(this).attr('id');
			var action = 'fetch_single';
			$.ajax({
				url: "action.php",
				method: "POST",
				data: { id: id, action: action },
				dataType: "json",
				success: function (data) {
					$('#Title').val(data.Title);
					$('#Day').val(data.Day);
					$('#Salary').val(data.Salary);
					$('#State').val(data.State);
					$('#City').val(data.City);
					$('#Zip').val(data.Zip_Code);
					$('#user_dialog').attr('title', 'Edit Data');
					$('#action').val('update');
					$('#hidden_id').val(id);
					$('#form_action').val('Update');
					$('#user_dialog').dialog('open');
				}
			});
		});

		$('#delete_confirmation').dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Ok: function () {
					var id = $(this).data('id');
					var action = 'delete';
					$.ajax({
						url: "action.php",
						method: "POST",
						data: { id: id, action: action },
						success: function (data) {
							$('#delete_confirmation').dialog('close');
							$('#action_alert').html(data);
							$('#action_alert').dialog('open');
							load_data();
						}
					});
				},
				Cancel: function () {
					$(this).dialog('close');
				}
			}
		});

		$(document).on('click', '.delete', function () {
			var id = $(this).attr("id");
			$('#delete_confirmation').data('id', id).dialog('open');
		});

	});  
</script>