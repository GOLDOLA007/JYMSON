<?php
    require_once __DIR__ . '/../model/Workout.php';
    require_once __DIR__ . '/../controller/workout-controller.php';
    require_once __DIR__ . '/../controller/user-controller.php';
    require_once __DIR__ . '/../controller/functions/general-functions.php';

    session_start();

    // Processar o formulário quando enviado
    if(isset($_POST['submit'])){
        $exercises_names = $_POST['exercise_names'] ?? [];
        $exercises_weights = $_POST['exercise_weights'] ?? [];
        $exercises_reps = $_POST['exercise_reps'] ?? [];
        $exercises_sets = $_POST['exercise_sets'] ?? [];
        $exercises = [];

        foreach($exercises_names as $index => $exercise_name){
            $name = trim($exercise_name);
            $weight = trim($exercises_weights[$index] ?? '');
            $reps = trim($exercises_reps[$index] ?? '');
            $sets = trim($exercises_sets[$index] ?? '');

            // Só adicionar se o nome do exercício não estiver vazio
            if($name !== ''){
                $exercises[] = [
                    "name" => $name,
                    "weight" => $weight !== '' ? $weight : 0,
                    "reps" => $reps !== '' ? $reps : 0,
                    "sets" => $sets !== '' ? $sets : 0
                ];
            }
        }

        // Verificar se há pelo menos um exercício
        if(empty($exercises)){
            $_SESSION['message'] = 'Please add at least one exercise.';
            $_SESSION['message_type'] = 'error';
            header("Location: add-workout-page.php");
            exit();
        } elseif(empty($_POST['name'])) {
            $_SESSION['message'] = 'Please enter a workout name.';
            $_SESSION['message_type'] = 'error';
            header("Location: add-workout-page.php");
            exit();
        } else {
            $new_workout = new Workout(
                $_POST['name'],
                $exercises,
                controller_get_code_user_by_email(),
                generate_code()
            );

            $response = controller_save_workout($new_workout);
            
            if($response === "success"){
                $_SESSION['message'] = 'Workout created successfully!';
                $_SESSION['message_type'] = 'success';
                header("Location: add-workout-page.php");
                exit();
            } else {
                $_SESSION['message'] = 'Error creating workout. Please try again.';
                $_SESSION['message_type'] = 'error';
                header("Location: add-workout-page.php");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Add Workout</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/main.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='../js/main.js'></script>
    <style>
        .exercise-header {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }
        
        .exercise-header label {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .exercise-row {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .exercise-header label:nth-child(1),
        .exercise-row input:nth-child(1) {
            flex: 3;
        }
        
        .exercise-header label:nth-child(2),
        .exercise-row input:nth-child(2) {
            flex: 1.5;
        }
        
        .exercise-header label:nth-child(3),
        .exercise-row input:nth-child(3) {
            flex: 1.5;
        }
        
        .exercise-header label:nth-child(4),
        .exercise-row input:nth-child(4) {
            flex: 1.5;
        }
        
        @media (max-width: 640px) {
            .exercise-header {
                display: none;
            }
            
            .exercise-row {
                flex-direction: column;
            }
            
            .exercise-row input {
                width: 100%;
            }
            
            .exercise-row input::before {
                content: attr(placeholder);
                display: block;
                font-size: 0.75rem;
                color: var(--muted);
                margin-bottom: 0.25rem;
            }
        }
        
        #add-exercise {
            width: 100%;
            margin: 0.5rem 0 1rem 0;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.15);
            color: var(--text);
            padding: 0.85rem 1rem;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        
        #add-exercise:hover {
            background: rgba(124, 58, 237, 0.2);
            border-color: var(--accent);
            transform: translateY(-1px);
        }
        
        .button-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            margin-top: 1rem;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.15);
        }
        
        .button-link:hover {
            background: rgba(124, 58, 237, 0.2);
            border-color: var(--accent);
            text-decoration: none;
        }
        
        .message {
            margin: 1rem 0 0;
            padding: 0.85rem 1rem;
            border-radius: 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
        
        h3 i {
            margin-right: 0.5rem;
            color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>
                <i class="fa fa-plus-circle"></i> Add Workout
            </h3>

            <input 
                placeholder="Workout Name" 
                type="text" 
                name="name" 
                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
                required
            />

            <div id="exercises-wrapper">
                <div class="exercise-header">
                    <label>Exercise</label>
                    <label>Weight(KG)</label>
                    <label>Reps</label>
                    <label>Sets</label>
                </div>
                
                <div class="exercise-row">
                    <input placeholder="Exercise" type="text" name="exercise_names[]" class="exercise-input" value="" required/>
                    <input placeholder="Weight" type="text" name="exercise_weights[]" class="exercise-input" value=""/>
                    <input placeholder="Reps" type="text" name="exercise_reps[]" class="exercise-input" value=""/>
                    <input placeholder="Sets" type="text" name="exercise_sets[]" class="exercise-input" value=""/>
                </div>
            </div>
            
            <button type="button" id="add-exercise">
                <i class="fa fa-plus"></i> Add Exercise
            </button>

            <input type="submit" name="submit" value="Create Workout">
            
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
        </form>

        <a class="button-link" href="mainMenu-page.php">
            <i class="fa fa-arrow-left"></i> Back to workouts
        </a>
    </div>
</body>
</html>