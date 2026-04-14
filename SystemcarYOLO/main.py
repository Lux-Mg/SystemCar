import sys
import os
import cv2
import csv
import sqlite3
from datetime import datetime
from PyQt6 import QtCore, QtGui, QtWidgets
from PyQt6.QtWidgets import QFileDialog, QMessageBox
from ultralytics import YOLO


class DetectionThread(QtCore.QThread):
    frame_updated = QtCore.pyqtSignal(QtGui.QImage)

    def __init__(self, video_path, model_path, parent=None):
        super().__init__(parent)
        self.video_path = video_path
        self.model = YOLO(model_path)
        self.running = False

        self.conn = sqlite3.connect("detecciones.db", check_same_thread=False)
        self.cursor = self.conn.cursor()
        self.cursor.execute('''
            CREATE TABLE IF NOT EXISTS conteos (
                class_name TEXT,
                timestamp TEXT,
                count INTEGER
            )
        ''')
        self.conn.commit()

    def run(self):
        try:
            use_cuda = self.model.device.type == 'cuda'
            print("CUDA disponible:", use_cuda)

            cap = cv2.VideoCapture(self.video_path)
            self.running = True

            while self.running and cap.isOpened():
                ret, frame = cap.read()
                if not ret:
                    break

                results = self.model(frame)[0]

                class_counts = {}
                for r in results.boxes.data.tolist():
                    cls_id = int(r[5])
                    cls_name = self.model.names[cls_id]
                    class_counts[cls_name] = class_counts.get(cls_name, 0) + 1

                timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
                for cls_name, count in class_counts.items():
                    self.cursor.execute("INSERT INTO conteos (class_name, timestamp, count) VALUES (?, ?, ?)",
                                        (cls_name, timestamp, count))
                self.conn.commit()

                rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
                h, w, ch = rgb.shape
                qt_img = QtGui.QImage(
                    rgb.data, w, h, ch * w, QtGui.QImage.Format.Format_RGB888)
                self.frame_updated.emit(qt_img)

            cap.release()
            self.conn.close()

        except Exception as e:
            import traceback
            print("Error en hilo de detección:", e)
            traceback.print_exc()

    def stop(self):
        self.running = False
        self.wait()


class MainWindow(QtWidgets.QMainWindow):
    def __init__(self, video_path, model_path):
        super().__init__()
        self.setWindowTitle("YOLOv11 Detector")
        self.resize(900, 600)

        central = QtWidgets.QWidget()
        layout = QtWidgets.QHBoxLayout(central)

        self.video_label = QtWidgets.QLabel()
        self.video_label.setFixedSize(640, 480)
        layout.addWidget(self.video_label)

        boton_exportar = QtWidgets.QPushButton("Exportar a CSV")
        boton_exportar.clicked.connect(self.exportar_csv)
        layout.addWidget(boton_exportar)

        self.setCentralWidget(central)

        self.thread = DetectionThread(video_path, model_path)
        self.thread.frame_updated.connect(self.update_frame)
        self.thread.start()

    @QtCore.pyqtSlot(QtGui.QImage)
    def update_frame(self, image):
        pix = QtGui.QPixmap.fromImage(image).scaled(
            self.video_label.size(), QtCore.Qt.AspectRatioMode.KeepAspectRatio)
        self.video_label.setPixmap(pix)

    def exportar_csv(self):
        try:
            filepath, _ = QFileDialog.getSaveFileName(
                self,
                "Guardar como CSV",
                "conteos.csv",
                "CSV Files (*.csv)"
            )

            if not filepath:
                print("Cancelado por el usuario.")
                return

            with open("export_debug.log", "a", encoding="utf-8") as log:
                log.write(f"Ruta seleccionada: {filepath}\n")

            conn = sqlite3.connect("detecciones.db")
            cursor = conn.cursor()
            cursor.execute("SELECT * FROM conteos")
            rows = cursor.fetchall()
            conn.close()

            with open(filepath, "w", newline="", encoding="utf-8") as f:
                writer = csv.writer(f)
                writer.writerow(["Class Name", "Timestamp", "Count"])
                writer.writerows(rows)

            QMessageBox.information(
                self, "Éxito", f"Datos exportados correctamente a:\n{filepath}")

        except Exception as e:
            print("Error al exportar CSV:", e)
            import traceback
            traceback.print_exc()
            QMessageBox.critical(
                self, "Error", f"No se pudo guardar el archivo:\n{e}")

    def closeEvent(self, event):
        self.thread.stop()
        event.accept()


if __name__ == "__main__":
    video_path = "test_videos/4.mp4"
    model_path = "yolo11l.pt"

    app = QtWidgets.QApplication(sys.argv)
    win = MainWindow(video_path, model_path)
    win.show()
    sys.exit(app.exec())
