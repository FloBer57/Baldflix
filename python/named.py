import os
import random
import tkinter as tk
from tkinter import filedialog

def renommer_fichiers(dossier):
    # Liste des fichiers dans le dossier
    fichiers = os.listdir(dossier)

    # Parcourir tous les fichiers du dossier
    for fichier in fichiers:
        # Construire le chemin complet du fichier
        chemin_complet = os.path.join(dossier, fichier)

        # Vérifier si le fichier est un fichier PNG
        if os.path.isfile(chemin_complet) and fichier.lower().endswith(".png"):
            # Générer un nombre aléatoire initial
            nombre_aleatoire = random.randint(1, 1000)

            # Construire le nouveau nom de fichier
            nouveau_nom = f"bald_icon_{nombre_aleatoire}.png"

            # Vérifier s'il existe déjà un fichier avec le même nom
            while os.path.exists(os.path.join(dossier, nouveau_nom)):
                nombre_aleatoire = random.randint(1, 1000)
                nouveau_nom = f"bald_icon_{nombre_aleatoire}.png"

            # Construire le chemin complet du nouveau fichier
            nouveau_chemin = os.path.join(dossier, nouveau_nom)

            # Renommer le fichier
            os.rename(chemin_complet, nouveau_chemin)

            print(f"Renommage de {fichier} à {nouveau_nom}")

def parcourir_dossier():
    dossier = filedialog.askdirectory()
    if dossier:
        renommer_fichiers(dossier)

# Créer la fenêtre principale
fenetre = tk.Tk()
fenetre.title("Renommer les fichiers PNG")

# Créer un bouton pour parcourir le dossier
bouton_parcourir = tk.Button(fenetre, text="Parcourir le dossier", command=parcourir_dossier)
bouton_parcourir.pack(pady=20)

# Lancer la boucle principale de Tkinter
fenetre.mainloop()
