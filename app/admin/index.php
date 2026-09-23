<?php

require '../../config/config.php';



requireRole('admin');

// logActivity($pdo, $_SESSION['user_id'], $_SESSION['user_email'], 'view_activity_logs', 'success');

// Activity Logs Query Query #3

logActivity(
    $pdo,
    $_SESSION['user_id'],
    $_SESSION['user_email'],
'view_activity_logs',
'success'
);

//Activity logs query#3

 $stmt = $pdo->query("
    SELECT *
    FROM activity_logs
    ORDER BY activity_log_created_at DESC

 ");

 $activities = $stmt->fetchALL(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body>
    <h1>Welcome Admin</h1>
    <a href="../../auth/signout.php">Sign Out</a>
    <table border="1">

    <div class="container mt-4">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
    
 <div class="table-responsive"> 
    <table class="table table-striped table-bordered">
    </div>
        <thead>
            <tr>

                <th>Record ID</th>
                <th>User ID</th>
                <th>User Email</th>
                <th>Action</th>
                <th>Status</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Date & Time</th>
            </tr>
    
        </thead>
     
            <?php foreach ($activities as $activity): ?>
    <tr>
        <td> <?= htmlspecialchars( $activity['actvity_log_id']) ?></td>
             <td> <?= htmlspecialchars( $activity['user_id']) ?></td>
                  <td> <?= htmlspecialchars( $activity['user_email']) ?></td>
                       <td> <?= htmlspecialchars( $activity['activity_log_action']) ?></td>
                            <td> <?= htmlspecialchars( $activity['activity_log_status']) ?></td>
                                 <td> <?= htmlspecialchars( $activity['activity_log_ip_address']) ?></td>
                                      <td> <?= htmlspecialchars( $activity['activity_log_user_agent']) ?></td>
                                           <td> <?= htmlspecialchars( $activity['activity_log_created_at']) ?></td>
    </tr>
<?php endforeach; ?>



        </tbody>


    </table>


    <script> src = 	"https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" ></script>
</body>

</html>