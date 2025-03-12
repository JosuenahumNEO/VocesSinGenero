const questions = [
    {
        "question": "¿Qué es el Modelo de Equidad de Género (MEG)?",
        "answers": [
            { "text": "Un programa exclusivo para mujeres en el ámbito laboral", "correct": false },
            { "text": "Un modelo para fomentar la equidad de género en organizaciones", "correct": true },
            { "text": "Una iniciativa para eliminar a los hombres del liderazgo empresarial", "correct": false },
            { "text": "Un reglamento de vestimenta en empresas", "correct": false }
        ]
    },
    {
        "question": "¿Cuál es uno de los pilares fundamentales del MEG?",
        "answers": [
            { "text": "Promover la superioridad de un género sobre otro", "correct": false },
            { "text": "Eliminar la presencia masculina en el entorno laboral", "correct": false },
            { "text": "Implementar políticas de igualdad de oportunidades", "correct": true },
            { "text": "Garantizar que solo las mujeres puedan ascender en las empresas", "correct": false }
        ]
    },
    {
        "question": "¿Qué acción fomenta el MEG para prevenir el acoso y la violencia de género?",
        "answers": [
            { "text": "Ignorar denuncias para evitar conflictos internos", "correct": false },
            { "text": "Crear protocolos claros de identificación y sanción", "correct": true },
            { "text": "Dejar la resolución de estos problemas a criterio del personal", "correct": false },
            { "text": "Evitar contratar mujeres para prevenir acoso", "correct": false }
        ]
    },
    {
        "question": "¿Cómo busca el MEG equilibrar la vida laboral y personal?",
        "answers": [
            { "text": "Exigiendo que las mujeres trabajen menos horas", "correct": false },
            { "text": "Otorgando licencias de paternidad y maternidad equitativas", "correct": true },
            { "text": "Limitando el acceso de hombres a posiciones de liderazgo", "correct": false },
            { "text": "Prohibiendo que los empleados formen familias", "correct": false }
        ]
    },
    {
        "question": "¿Cómo se eliminan los sesgos de género en los procesos de selección y promoción?",
        "answers": [
            { "text": "Priorizando la contratación de mujeres", "correct": false },
            { "text": "Usando criterios claros y objetivos basados en méritos", "correct": true },
            { "text": "Evitando contratar personas con responsabilidades familiares", "correct": false },
            { "text": "Contratando únicamente a personas del mismo género para evitar conflictos", "correct": false }
        ]
    }
]
;

const questionElement = document.getElementById("question");
const answerButtons = document.getElementById("answer-buttons");
const nextButton = document.getElementById("next-btn");

let currentQuestionIndex = 0;
let score = 0;

function startQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    nextButton.innerHTML = "Siguiente pregunta";
    showQuestion();
}

function showQuestion() {
    resetState();
    let currentQuestion = questions[currentQuestionIndex];  // No declarar 'let currentQuestionIndex' aquí
    let questionNO = currentQuestionIndex + 1;
    questionElement.innerHTML = questionNO + ". " + currentQuestion.question;

    currentQuestion.answers.forEach(answer => {
        const button = document.createElement("button");
        button.innerHTML = answer.text;
        button.classList.add("btn");
        answerButtons.appendChild(button);
        if (answer.correct) {
            button.dataset.correct = answer.correct;
        }
        button.addEventListener("click", selectAnswer);
    });
}

function resetState() {
    nextButton.style.display = "none";
    while (answerButtons.firstChild) {
        answerButtons.removeChild(answerButtons.firstChild);
    }
}

function selectAnswer(e) {
    const selectedBtn = e.target;
    const isCorrect = selectedBtn.dataset.correct === "true";
    if (isCorrect) {
        selectedBtn.classList.add("correct");
        score++;
    } else {
        selectedBtn.classList.add("incorrect");
    }
    Array.from(answerButtons.children).forEach(button => {
        if (button.dataset.correct == "true") {
            button.classList.add("correct");
        }
        button.disabled = true;
    });
    nextButton.style.display = "block";
}

function showScore(){
    resetState();
    questionElement.innerHTML = `Tu puntaje es ${score} de ${questions.length}!`;

    nextButton.innerHTML="volver a intentar";
    nextButton.style.display="block";

}

function handleNextButton(){
    currentQuestionIndex++;
    if (currentQuestionIndex<questions.length) {
        showQuestion();
    }else{
        showScore();

    }
}

nextButton.addEventListener("click",()=>{
    if (currentQuestionIndex<questions.length) {
        handleNextButton();
    }else{
        startQuiz();
    }


})
startQuiz();
