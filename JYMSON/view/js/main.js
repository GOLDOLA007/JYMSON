document.addEventListener('DOMContentLoaded', function() {

    const workoutCards = document.querySelectorAll('.workout-card');
    workoutCards.forEach(card => {
        card.addEventListener('click', function () {
            const data = this.getAttribute('data-workout');

            try {
                const workout = JSON.parse(data);
                show_workout_details(workout);
            } catch (e) {
                console.error('Erro ao parsear workout:', e);
            }
            
        });
    });

    const exercisesWrapper = document.getElementById('exercises-wrapper');
    const addExerciseButton = document.getElementById('add-exercise');

    if (!exercisesWrapper || !addExerciseButton) return;

    function createExerciseRow(index, name = '', weight = '', reps = '', sets = '') {
        const row = document.createElement('div');
        row.className = 'exercise-row';
        row.style.display = 'flex';
        row.style.gap = '0.75rem';
        row.style.marginBottom = '0.75rem';
        row.style.flexWrap = 'wrap';

        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.name = 'exercise_names[]';
        nameInput.placeholder = 'Exercise';
        nameInput.className = 'exercise-input';
        nameInput.style.flex = '3';
        nameInput.style.minWidth = '0';
        nameInput.style.padding = '0.5rem';
        nameInput.style.background = 'rgba(15, 23, 42, 0.7)';
        nameInput.style.border = '1px solid rgba(148, 163, 184, 0.12)';
        nameInput.style.borderRadius = '12px';
        nameInput.style.color = 'var(--text)';
        nameInput.value = name;

        const weightInput = document.createElement('input');
        weightInput.type = 'text';
        weightInput.name = 'exercise_weights[]';
        weightInput.placeholder = 'Weight';
        weightInput.className = 'exercise-input';
        weightInput.style.flex = '1.5';
        weightInput.style.minWidth = '0';
        weightInput.style.padding = '0.5rem';
        weightInput.style.background = 'rgba(15, 23, 42, 0.7)';
        weightInput.style.border = '1px solid rgba(148, 163, 184, 0.12)';
        weightInput.style.borderRadius = '12px';
        weightInput.style.color = 'var(--text)';
        weightInput.value = weight;

        const repsInput = document.createElement('input');
        repsInput.type = 'text';
        repsInput.name = 'exercise_reps[]';
        repsInput.placeholder = 'Reps';
        repsInput.className = 'exercise-input';
        repsInput.style.flex = '1.5';
        repsInput.style.minWidth = '0';
        repsInput.style.padding = '0.5rem';
        repsInput.style.background = 'rgba(15, 23, 42, 0.7)';
        repsInput.style.border = '1px solid rgba(148, 163, 184, 0.12)';
        repsInput.style.borderRadius = '12px';
        repsInput.style.color = 'var(--text)';
        repsInput.value = reps;

        const setsInput = document.createElement('input');
        setsInput.type = 'text';
        setsInput.name = 'exercise_sets[]';
        setsInput.placeholder = 'Sets';
        setsInput.className = 'exercise-input';
        setsInput.style.flex = '1.5';
        setsInput.style.minWidth = '0';
        setsInput.style.padding = '0.5rem';
        setsInput.style.background = 'rgba(15, 23, 42, 0.7)';
        setsInput.style.border = '1px solid rgba(148, 163, 184, 0.12)';
        setsInput.style.borderRadius = '12px';
        setsInput.style.color = 'var(--text)';
        setsInput.value = sets;

        row.appendChild(nameInput);
        row.appendChild(weightInput);
        row.appendChild(repsInput);
        row.appendChild(setsInput);
        return row;
    }

    addExerciseButton.addEventListener('click', function() {
        const rowCount = exercisesWrapper.querySelectorAll('.exercise-row').length;
        exercisesWrapper.appendChild(createExerciseRow(rowCount + 1));
    });
});

function togglePassword(inputId, iconElement) {
    const password = document.getElementById(inputId);
    if (!password) {
        return;
    }

    const isHidden = password.type === "password";
    password.type = isHidden ? "text" : "password";

    if (iconElement) {
        iconElement.classList.toggle("fa-eye");
        iconElement.classList.toggle("fa-eye-slash");
    }
}

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function isMobile() {
    return window.innerWidth <= 768;
}

function show_workout_details(workout) {
    if (window.__renderingWorkout) return; 
    window.__renderingWorkout = true;

    const container = document.getElementById('workout-details-container');
    if (!container) {
        alert('Workout details panel not found.');
        window.__renderingWorkout = false;
        return;
    }

    if (!workout || typeof workout !== 'object') {
        container.style.display = 'none';
        alert('No workout data available.');
        window.__renderingWorkout = false;
        return;
    }

    // Salvar os dados do workout atual para redimensionamento
    container.setAttribute('data-current-workout', JSON.stringify(workout));

    // Pegar os exercícios corretamente
    let exercises = workout.workout_exercises || [];
    
    if (!Array.isArray(exercises)) {
        exercises = [exercises];
    }
    
    if (exercises.length === 0) {
        exercises = [{ name: '', weight: '', reps: '', sets: '' }];
    }

    const mobile = isMobile();
    
    // Gerar os campos de exercício
    let exerciseFields = '';
    
    if (!mobile) {
        // DESKTOP: cabeçalho em linha
        exerciseFields += `
            <div class="exercise-header" style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; padding: 0.5rem 0; border-bottom: 1px solid rgba(148, 163, 184, 0.2);">
                <label style="flex: 3; margin: 0; font-size: 0.85rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Exercise</label>
                <label style="flex: 1.5; margin: 0; font-size: 0.85rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Weight (kg)</label>
                <label style="flex: 1.5; margin: 0; font-size: 0.85rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Reps</label>
                <label style="flex: 1.5; margin: 0; font-size: 0.85rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;">Sets</label>
            </div>
        `;
    }
    
    // Adicionar cada exercício
    exercises.forEach((exercise, index) => {
        const name = exercise?.name || '';
        const weight = exercise?.weight || '';
        const reps = exercise?.reps || '';
        const sets = exercise?.sets || '';

        if (mobile) {
            // MOBILE: cada campo em uma linha separada com label
            exerciseFields += `
                <div class="exercise-card-mobile" style="background: rgba(15, 23, 42, 0.5); border-radius: 16px; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid rgba(148, 163, 184, 0.1);">
                    <div style="margin-bottom: 0.75rem;">
                        <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Exercise</label>
                        <input type="text" name="exercise_names[]" value="${escapeHtml(name)}" placeholder="Exercise" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 80px;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Weight (kg)</label>
                            <input type="text" name="exercise_weights[]" value="${escapeHtml(weight)}" placeholder="Weight" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                        </div>
                        <div style="flex: 1; min-width: 80px;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Reps</label>
                            <input type="text" name="exercise_sets[]" value="${escapeHtml(sets)}" placeholder="Reps" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                        </div>
                        <div style="flex: 1; min-width: 80px;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Sets</label>
                            <input type="text" name="exercise_reps[]" value="${escapeHtml(reps)}" placeholder="Sets" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                        </div>
                    </div>
                </div>
            `;
        } else {
            // DESKTOP: linha única com todos os campos
            exerciseFields += `
                <div class="exercise-row" style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem;">
                    <input type="text" name="exercise_names[]" value="${escapeHtml(name)}" placeholder="Exercise" style="flex: 3; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                    <input type="text" name="exercise_weights[]" value="${escapeHtml(weight)}" placeholder="Weight (kg)" style="flex: 1.5; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                    <input type="text" name="exercise_reps[]" value="${escapeHtml(reps)}" placeholder="Reps" style="flex: 1.5; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                    <input type="text" name="exercise_sets[]" value="${escapeHtml(sets)}" placeholder="Sets" style="flex: 1.5; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                </div>
            `;
        }
    });

    container.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
            <h4 style="margin: 0; color: #f8fafc;">Workout Details</h4>
            <button type="button" id="close-workout-details" style="background: none; border: none; cursor: pointer; font-size: 1.25rem; color: #64748b;">
                <i class="fa fa-window-close" aria-hidden="true"></i>
            </button>
        </div>
        <form id="workout-details-form" method="post">
            <input type="hidden" name="update_workout" value="1" />
            <input type="hidden" name="code_workout" value="${escapeHtml(workout.workout_code || '')}" />

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #94a3b8;">Workout Name</label>
                <input type="text" name="name" value="${escapeHtml(workout.workout_name || '')}" style="width: 100%; padding: 0.75rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
            </div>

            <div id="workout-exercises-list">
                ${exerciseFields}
            </div>

            <button type="button" id="add-workout-exercise" style="width: 100%; margin: 0.5rem 0 1rem 0; padding: 0.75rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(148, 163, 184, 0.15); border-radius: 12px; color: var(--text); font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i class="fa fa-plus"></i> Add Exercise
            </button>
            
            <div>
                <button type="submit" style="width: 100%; padding: 0.85rem; background: linear-gradient(135deg, #7c3aed 0%, #60a5fa 100%); color: #fff; font-weight: 700; border: none; border-radius: 12px; cursor: pointer;">
                    <i class="fa fa-save"></i> Save Workout
                </button>
            </div>
        </form>
    `;

    container.style.display = 'block';

    // Adicionar novo exercício
    const addButton = document.getElementById('add-workout-exercise');
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            const list = document.getElementById('workout-exercises-list');
            const mobileView = isMobile();
            
            if (mobileView) {
                // MOBILE: adicionar card com labels
                const newExerciseCard = document.createElement('div');
                newExerciseCard.className = 'exercise-card-mobile';
                newExerciseCard.style.background = 'rgba(15, 23, 42, 0.5)';
                newExerciseCard.style.borderRadius = '16px';
                newExerciseCard.style.padding = '0.75rem';
                newExerciseCard.style.marginBottom = '1rem';
                newExerciseCard.style.border = '1px solid rgba(148, 163, 184, 0.1)';
                
                newExerciseCard.innerHTML = `
                    <div style="margin-bottom: 0.75rem;">
                        <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Exercise</label>
                        <input type="text" name="exercise_names[]" value="" placeholder="Exercise" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 80px;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Weight (kg)</label>
                            <input type="text" name="exercise_weights[]" value="" placeholder="Weight" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                        </div>
                        <div style="flex: 1; min-width: 80px;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Reps</label>
                            <input type="text" name="exercise_reps[]" value="" placeholder="Reps" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                        </div>
                        <div style="flex: 1; min-width: 80px;">
                            <label style="display: block; font-size: 0.7rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.25rem;">Sets</label>
                            <input type="text" name="exercise_sets[]" value="" placeholder="Sets" style="width: 100%; padding: 0.6rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 10px; color: var(--text);" />
                        </div>
                    </div>
                `;
                list.appendChild(newExerciseCard);
            } else {
                // DESKTOP: adicionar linha normal
                const newExerciseRow = document.createElement('div');
                newExerciseRow.className = 'exercise-row';
                newExerciseRow.style.display = 'flex';
                newExerciseRow.style.gap = '0.75rem';
                newExerciseRow.style.marginBottom = '0.75rem';
                
                newExerciseRow.innerHTML = `
                    <input type="text" name="exercise_names[]" value="" placeholder="Exercise" style="flex: 3; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                    <input type="text" name="exercise_weights[]" value="" placeholder="Weight (kg)" style="flex: 1.5; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                    <input type="text" name="exercise_reps[]" value="" placeholder="Reps" style="flex: 1.5; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                    <input type="text" name="exercise_sets[]" value="" placeholder="Sets" style="flex: 1.5; padding: 0.5rem; background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(148, 163, 184, 0.12); border-radius: 12px; color: var(--text);" />
                `;
                list.appendChild(newExerciseRow);
            }
        });
    }

    const closeButton = document.getElementById('close-workout-details');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            container.style.display = 'none';
            window.__renderingWorkout = false;
        });
    }
    
    window.__renderingWorkout = false;
}

// Adicionar listener para redimensionamento da tela
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        const container = document.getElementById('workout-details-container');
        if (container && container.style.display === 'block') {
            const workoutData = container.getAttribute('data-current-workout');
            if (workoutData) {
                try {
                    const workout = JSON.parse(workoutData);
                    show_workout_details(workout);
                } catch(e) {
                    console.error('Erro ao recarregar:', e);
                }
            }
        }
    }, 250);
});