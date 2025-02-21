from flask import Flask, request, render_template, redirect, url_for, session
import os
import random

app = Flask(__name__)
app.secret_key = 'tu_clave_secreta_aqui'  # Clave secreta para manejar sesiones

# Configuración de carpetas
UPLOAD_FOLDER = 'uploads'
GENERIC_FOLDER = 'static/generic'
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# Crear carpetas si no existen
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)
if not os.path.exists(GENERIC_FOLDER):
    os.makedirs(GENERIC_FOLDER)

# Ruta para subir fotos
@app.route('/upload', methods=['GET', 'POST'])
def upload():
    if request.method == 'POST':
        # Guardar las 3 fotos subidas por el usuario
        uploaded_files = request.files.getlist('photos')
        if len(uploaded_files) != 3:
            return "Debes subir exactamente 3 fotos.", 400

        session['user_photos'] = []
        for file in uploaded_files:
            if file.filename != '':
                file_path = os.path.join(app.config['UPLOAD_FOLDER'], file.filename)
                file.save(file_path)
                session['user_photos'].append(file_path)

        return redirect(url_for('captcha'))
    return render_template('upload.html')

# Ruta para el CAPTCHA
@app.route('/captcha', methods=['GET', 'POST'])
def captcha():
    if 'user_photos' not in session:
        return redirect(url_for('upload'))

    if request.method == 'POST':
        # Verificar las fotos seleccionadas por el usuario
        selected_photos = request.form.getlist('photos')
        user_photos = session.get('user_photos', [])
        if set(selected_photos) == set(user_photos):
            return "¡Verificación exitosa!"
        else:
            return "Fotos incorrectas. Intenta de nuevo."
    # Mezclar fotos del usuario con fotos genéricas
    all_photos = session.get('user_photos', []) + [
        os.path.join(GENERIC_FOLDER, f) for f in os.listdir(GENERIC_FOLDER)
    ]
    random.shuffle(all_photos)
    return render_template('captcha.html', photos=all_photos)
if __name__ == '__main__':
    app.run(debug=True)