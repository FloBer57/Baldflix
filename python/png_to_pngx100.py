from PIL import Image
import os
import tkinter as tk
from tkinter import filedialog

class ImageResizerApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Image Resizer")

        # Variables pour les chemins des dossiers
        self.input_folder_path = tk.StringVar()
        self.output_folder_path = tk.StringVar()

        # Créer l'interface graphique
        self.create_gui()

    def create_gui(self):
        # Cadre principal
        main_frame = tk.Frame(self.root, padx=20, pady=20)
        main_frame.pack()

        # Étiquettes et champs de saisie pour les dossiers d'entrée et de sortie
        tk.Label(main_frame, text="Dossier d'entrée:").grid(row=0, column=0, sticky="e")
        tk.Entry(main_frame, textvariable=self.input_folder_path, width=40).grid(row=0, column=1)
        tk.Button(main_frame, text="Parcourir", command=self.browse_input_folder).grid(row=0, column=2)

        tk.Label(main_frame, text="Dossier de sortie:").grid(row=1, column=0, sticky="e")
        tk.Entry(main_frame, textvariable=self.output_folder_path, width=40).grid(row=1, column=1)
        tk.Button(main_frame, text="Parcourir", command=self.browse_output_folder).grid(row=1, column=2)

        # Bouton pour redimensionner les images
        tk.Button(main_frame, text="Redimensionner", command=self.resize_images).grid(row=2, columnspan=3)

    def browse_input_folder(self):
        folder_selected = filedialog.askdirectory()
        self.input_folder_path.set(folder_selected)

    def browse_output_folder(self):
        folder_selected = filedialog.askdirectory()
        self.output_folder_path.set(folder_selected)

    def resize_images(self):
        input_folder = self.input_folder_path.get()
        output_folder = self.output_folder_path.get()

        if not input_folder or not output_folder:
            tk.messagebox.showerror("Erreur", "Veuillez sélectionner les dossiers d'entrée et de sortie.")
            return

        if not os.path.exists(output_folder):
            os.makedirs(output_folder)

        files = os.listdir(input_folder)

        for file in files:
            if file.lower().endswith(".png"):
                input_path = os.path.join(input_folder, file)
                output_path = os.path.join(output_folder, file)

                img = Image.open(input_path)
                img_resized = img.resize((100, 100))
                img_resized.save(output_path, "PNG")

        tk.messagebox.showinfo("Redimension terminée", "La redimension des images est terminée.")

if __name__ == "__main__":
    root = tk.Tk()
    app = ImageResizerApp(root)
    root.mainloop()
