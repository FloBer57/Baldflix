import os
import tkinter as tk
from tkinter import filedialog
from tkinter import simpledialog

def rename_files(folder_path, base_name, season_number):
    files = [f for f in os.listdir(folder_path) if os.path.isfile(os.path.join(folder_path, f))]
    episode_number = 1

    for file in sorted(files):
        file_extension = os.path.splitext(file)[1]
        new_name = f"{base_name}_S{str(season_number).zfill(2)}_EP{str(episode_number).zfill(2)}{file_extension}"
        os.rename(os.path.join(folder_path, file), os.path.join(folder_path, new_name))
        episode_number += 1

def choose_folder():
    folder_path = filedialog.askdirectory()
    if folder_path:
        base_name = simpledialog.askstring("Nom de la série", "Entrez le nom de base pour les fichiers :")
        if base_name:
            season_number = simpledialog.askstring("Numéro de la saison", "Entrez le numéro de la saison :")
            if season_number:
                try:
                    season_number = int(season_number)
                    rename_files(folder_path, base_name.replace(' ', '_'), season_number)
                    tk.messagebox.showinfo("Succès", "Les fichiers ont été renommés avec succès.")
                except ValueError:
                    tk.messagebox.showerror("Erreur", "Le numéro de la saison doit être un nombre.")

root = tk.Tk()
root.title("Renommeur de fichiers vidéo")

choose_folder_button = tk.Button(root, text="Choisir un dossier et renommer les fichiers", command=choose_folder)
choose_folder_button.pack(pady=20)

root.mainloop()
