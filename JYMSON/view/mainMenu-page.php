<?php 
    require_once __DIR__ . "/../controller/user-controller.php";
    require_once __DIR__ . "/../controller/workout-controller.php";
    session_start();

    $user_code = controller_get_code_user_by_email();
    $workouts = controller_get_workouts_by_user_code($user_code);

    // Processar atualização do workout
    if(isset($_POST['update_workout'])){
        $exercise_names = $_POST['exercise_names'] ?? [];
        $exercise_weights = $_POST['exercise_weights'] ?? [];
        $exercise_sets = $_POST['exercise_sets'] ?? [];
        $exercise_reps = $_POST['exercise_reps'] ?? [];
        $exercises = [];

        foreach($exercise_names as $index => $exercise_name){
            $name = trim($exercise_name);
            $weight = trim($exercise_weights[$index] ?? '');
            $sets = trim($exercise_sets[$index] ?? '');
            $reps = trim($exercise_reps[$index] ?? '');

            if($name != ''){
                $exercises[] = [
                    'name' => $name,
                    'weight' => $weight != '' ? $weight : 0,
                    "reps" => $reps != '' ? $reps : 0,
                    "sets" => $sets != '' ? $sets : 0
                ];
            }
        }

        $updated_workout = new Workout(
            $_POST['name'],
            $exercises,
            controller_get_code_user_by_email(),
            $_POST['code_workout']
        );
        
        if(controller_update_workout($updated_workout) === "success"){
            $_SESSION['message'] = 'Workout updated successfully.';
            $_SESSION['message_type'] = 'success';
            header("Location: mainMenu-page.php");
            exit();   
        } else {
            $_SESSION['message'] = 'Error updating workout. Please try again.';
            $_SESSION['message_type'] = 'error';
            header("Location: mainMenu-page.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>My Workouts - Fitness App</title>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/main.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='../js/main.js'></script>
    <style>
        /* Estilos responsivos completos */
        
        /* Container de workouts */
        .workouts-container {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        /* Mensagens */
        .message {
            margin: 1rem 0 0;
            padding: 0.85rem 1rem;
            border-radius: 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .message.success {
            background: rgba(34, 197, 94, 0.14);
            color: #dcfce7;
            border-left: 3px solid var(--success);
        }
        
        .message.error {
            background: rgba(239, 68, 68, 0.14);
            color: #fecaca;
            border-left: 3px solid var(--error);
        }
        
        .message i {
            font-size: 1rem;
        }
        
        /* Animações */
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
                visibility: hidden;
            }
        }
        
        .auto-hide {
            animation: fadeOut 0.5s ease-in 3s forwards;
        }
        
        /* ============================================ */
        /* RESPONSIVIDADE COMPLETA */
        /* ============================================ */
        
        /* Tablets (max-width: 768px) */
        @media (max-width: 768px) {
            .page-shell {
                padding: 0.5rem;
            }
            
            .section-card {
                padding: 1rem;
            }
            
            .workout-card {
                padding: 0.85rem;
            }
            
            .workout-card h5 {
                font-size: 0.9rem;
            }
        }
        
        /* Mobile (max-width: 640px) */
        @media (max-width: 640px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
            }
            
            .page-header h3 {
                font-size: 1.3rem;
                margin-bottom: 0;
            }
            
            .button-link {
                width: 100%;
                justify-content: center;
            }
            
            .section-card {
                padding: 1rem;
                border-radius: 20px;
            }
            
            .section-card h4 {
                font-size: 1rem;
                margin-bottom: 0.75rem;
            }
            
            .workout-card {
                padding: 0.85rem;
                margin-bottom: 0.5rem;
            }
            
            .workout-card h5 {
                font-size: 0.9rem;
            }
            
            .workout-card i {
                font-size: 1rem;
            }
        }
        
        /* Mobile pequeno (max-width: 480px) */
        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }
            
            .page-shell {
                padding: 0.25rem;
            }
            
            .page-header h3 {
                font-size: 1.2rem;
            }
            
            .button-link {
                padding: 0.7rem;
                font-size: 0.85rem;
            }
            
            .section-card {
                padding: 0.85rem;
            }
            
            .workout-card {
                padding: 0.7rem;
            }
            
            .workout-card h5 {
                font-size: 0.85rem;
            }
            
            .message {
                padding: 0.7rem;
                font-size: 0.85rem;
            }
        }
        
        /* Estilo para o container de detalhes do workout */
        #workout-details-container {
            margin-top: 1.5rem;
        }
        
        /* Exercício rows dentro do container de detalhes */
        #workout-details-container .exercise-row {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        #workout-details-container .exercise-row input {
            flex: 1;
            padding: 0.5rem;
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.12);
            border-radius: 12px;
            color: var(--text);
        }
        
        /* Responsividade para os detalhes do workout */
        @media (max-width: 640px) {
            #workout-details-container .exercise-header {
                display: none;
            }
            
            #workout-details-container .exercise-row {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            #workout-details-container .exercise-row input {
                width: 100%;
            }
            
            #workout-details-container .exercise-row input::placeholder {
                font-size: 0.85rem;
            }
        }
        
        /* Touch-friendly - aumenta área de clique em mobile */
        @media (max-width: 768px) {
            .workout-card,
            .button-link {
                min-height: 48px;
            }
            
            .workout-card {
                min-height: 60px;
            }
        }
        
        /* Landscape mode */
        @media (max-height: 600px) and (orientation: landscape) {
            .page-shell {
                padding: 0.5rem;
            }
            
            .section-card {
                margin-bottom: 0.5rem;
            }
            
            .workouts-container {
                max-height: 50vh;
                overflow-y: auto;
            }
        }
    </style>
</head>
<body>
    <main class="page-shell">
        <header class="page-header">
            <div>
                <h3>
                    <i class="fa fa-user"></i> 
                    <?php 
                        $user_name = controller_get_name_user_by_email();
                        if($user_name !== null){
                            echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8');
                        }else{
                            echo "User";
                        }
                    ?>
                </h3>
                
                <?php if(isset($_SESSION['message']) && !empty($_SESSION['message'])): ?>
                    <div class="message <?php echo $_SESSION['message_type'] ?? 'success'; ?>" id="session-message">
                        <i class="fa <?php echo ($_SESSION['message_type'] ?? 'success') === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                        <?php 
                            echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                        ?>
                    </div>
                    
                    <script>
                        setTimeout(function() {
                            const message = document.getElementById('session-message');
                            if (message) {
                                message.classList.add('auto-hide');
                                setTimeout(function() {
                                    if (message && message.parentNode) {
                                        message.remove();
                                    }
                                }, 3500);
                            }
                        }, 3000);
                    </script>
                <?php endif; ?>
            </div>
            <a class="button-link" href="add-workout-page.php">
                <i class="fa fa-plus"></i> Add workout
            </a>
        </header>

        <section class="section-card">
            <h4>My Workouts</h4>
            <div class="workouts-container">
                <?php 
                    if($workouts !== "error" && !empty($workouts)){
                        foreach($workouts as $workout){
                            $workoutData = [
                                'workout_name' => $workout->workout_name,
                                'workout_code' => $workout->workout_code,
                                'workout_exercises' => $workout->workout_exercises,
                                'user_code' => $workout->user_code ?? $user_code
                            ];
                            $jsonData = json_encode($workoutData);
                            ?>
                            <button 
                                class="workout-card" 
                                data-workout='<?php echo htmlspecialchars($jsonData, ENT_QUOTES, 'UTF-8'); ?>'
                            >
                                <i class='fa fa-folder'></i>
                                <h5><?php echo htmlspecialchars($workout->workout_name, ENT_QUOTES, 'UTF-8'); ?></h5>
                            </button>
                            <?php
                        }
                    } else {
                        ?>
                        <p class="error">
                            <i class="fa fa-info-circle"></i> No workouts found. Click "Add workout" to create one.
                        </p>
                        <?php
                    }
                ?>
            </div>
        </section>

        <div id="workout-details-container" style="display:none;"></div>

        <a class="button-link" href="login-page.php">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </main>
</body>
</html>