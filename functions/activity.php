<?php

function logActivity($pdo, $user_id, $user_email, $action, $status = 'success')
{
    try {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? 'Unknown';

        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }

        $user_agent = substr(
            $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            0,
            255
        );

        $stmt = $pdo->prepare("
            INSERT INTO activity_logs (
                user_id,
                user_email,
                activity_log_action,
                activity_log_status,
                activity_log_ip_address,
                activity_log_user_agent
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        $success = $stmt->execute([
            $user_id,
            $user_email,
            $action,
            $status,
            $ip,
            $user_agent
        ]);

        return $success;

    } catch (PDOException $e) {
        error_log("Activity Log Error: " . $e->getMessage());
        return false;
    }
}

?>