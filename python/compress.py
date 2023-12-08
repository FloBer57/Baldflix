from PIL import Image, ImageTk
import os
import tkinter as tk
from tkinter import filedialog

def resize_and_compress(input_path, output_path, max_size=(250, 250)):
    original_image = Image.open(input_path)
    original_image.thumbnail(max_size, Image.ANTIALIAS)
    original_image.save(output_path, optimize=True, quality=85)

def select_input_folder():
    folder_path = filedialog.askdirectory()
    input_folder_entry.delete(0, tk.END)
    input_folder_entry.insert(0, folder_path)

def select_output_folder():
    folder_path = filedialog.askdirectory()
    output_folder_entry.delete(0, tk.END)
    output_folder_entry.insert(0, folder_path)

def process_images():
    try:
        input_folder = input_folder_entry.get()
        output_folder = output_folder_entry.get()

        if not os.path.exists(input_folder) or not os.path.exists(output_folder):
            result_label.config(text="Les dossiers d'entrée et de sortie doivent être valides.")
            return

        input_files = os.listdir(input_folder)
        for input_file in input_files:
            input_path = os.path.join(input_folder, input_file)
            output_path = os.path.join(output_folder, input_file)
            resize_and_compress(input_path, output_path)

        result_label.config(text="Images traitées avec succès!")
    except Exception as e:
        result_label.config(text=f"Erreur : {str(e)}")

# Créer une fenêtre principale
root = tk.Tk()
root.title("Redimensionner et Compresser des Images")

# Créer et placer les widgets dans la fenêtre
input_folder_label = tk.Label(root, text="Dossier d'entrée:")
input_folder_label.grid(row=0, column=0, padx=10, pady=10, sticky=tk.W)

input_folder_entry = tk.Entry(root, width=40)
input_folder_entry.grid(row=0, column=1, padx=10, pady=10)

input_folder_button = tk.Button(root, text="Parcourir", command=select_input_folder)
input_folder_button.grid(row=0, column=2, padx=10, pady=10)

output_folder_label = tk.Label(root, text="Dossier de sortie:")
output_folder_label.grid(row=1, column=0, padx=10, pady=10, sticky=tk.W)

output_folder_entry = tk.Entry(root, width=40)
output_folder_entry.grid(row=1, column=1, padx=10, pady=10)

output_folder_button = tk.Button(root, text="Parcourir", command=select_output_folder)
output_folder_button.grid(row=1, column=2, padx=10, pady=10)

process_button = tk.Button(root, text="Traiter les images", command=process_images)
process_button.grid(row=2, column=0, columnspan=3, pady=20)

result_label = tk.Label(root, text="")
result_label.grid(row=3, column=0, columnspan=3)

# Démarrer la boucle principale de Tkinter
root.mainloop()
