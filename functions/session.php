<?php
// Start User Session

function startUserSession($pdo)
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("
        INSERT INTO user_sessions (
            user_id,
            session_start
        )
        VALUES (
            :user_id,
            NOW()
        )
    ");
    
    $stmt->execute([
        'user_id' => $user_id
    ]);

    // Store the session ID so endUserSession can access it
    $_SESSION['session_id'] = $pdo->lastInsertId();

    return $_SESSION['session_id'];
}

function endUserSession($pdo)
{
    if (!isset($_SESSION['session_id'])) {
        return false;
    }

    $session_id = $_SESSION['session_id']; // Fixed typo: $SESSION -> $_SESSION

    $stmt = $pdo->prepare("
        UPDATE user_sessions
        SET
            session_end = NOW(),
            session_duration = TIMESTAMPDIFF(
                SECOND,
                session_start,
                NOW()
            )
        WHERE session_id = :session_id
    ");

    return $stmt->execute([
        'session_id' => $session_id
    ]);
}

function hasActiveUserSession($pdo,$user_id){

$stmt= $pdo->prepare("
       SELECT session_id
       FROM user_sessions
       WHERE user_id = :user_id
       AND session_end IS NULL
       LIMIT 1  
       ");

       $stmt->execute([
           'user_id' => $user_id

       ]);

       return (bool) $stmt->fetchColumn();
}
  function checkSessionTimeout()
{
    global $pdo;

    $timeout = 1800; // 30 mins

    if (isset($_SESSION['last_activity'])) {
        $inactive = time() - $_SESSION['last_activity'];

        if ($inactive >= $timeout) {
            logActivity(
                $pdo,
                $_SESSION['user_id'] ?? null,
                $_SESSION['user_email'] ?? null,
                'logout-session-timeout',
                'success'
            );

            endUserSession($pdo);
            session_unset();
            session_destroy();

            header('Location: ' . BASE_URL . '/index.php?timeout=1');
            exit; // stop the script after redirecting
        }
    }

    $_SESSION['last_activity'] = time();
}
?>