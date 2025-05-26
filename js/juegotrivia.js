let currentQuestionIndex = 0;
let score = 0;

const questionElement = document.getElementById("question");
const answerButtons = document.getElementById("answer-buttons");
const nextButton = document.getElementById("next-btn");

function showQuestion() {
  resetState();

  const q = preguntas[currentQuestionIndex];
  questionElement.innerText = q.pregunta;

  ["A", "B", "C", "D"].forEach(letter => {
    const btn = document.createElement("button");
    btn.innerText = q["opcion_" + letter.toLowerCase()];
    btn.classList.add("btn");
    btn.dataset.correct = (letter === q.respuesta_correcta);
    btn.addEventListener("click", selectAnswer);
    answerButtons.appendChild(btn);
  });
}

function resetState() {
  nextButton.style.display = "none";
  answerButtons.innerHTML = "";
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

  Array.from(answerButtons.children).forEach(btn => {
    btn.disabled = true;
    if (btn.dataset.correct === "true") {
      btn.classList.add("correct");
    }
  });

  nextButton.style.display = "block";
}

nextButton.addEventListener("click", () => {
  currentQuestionIndex++;
  if (currentQuestionIndex < preguntas.length) {
    showQuestion();
  } else {
    showScore();
  }
});

function showScore() {
  resetState();
  questionElement.innerText = `¡Terminaste! Obtuviste ${score} de ${preguntas.length} correctas.`;
  nextButton.innerText = "Volver a jugar";
  nextButton.style.display = "block";
  nextButton.onclick = () => location.reload();
}

// Iniciar
showQuestion();
