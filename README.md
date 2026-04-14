# SystemCar — Parking Monitoring System

Real-time parking lot monitoring system that detects and counts vehicles using YOLO, with a web admin panel for managing parking data.

## Overview

SystemCar combines computer vision and a web backend to monitor parking lots in real time. A Python desktop app uses YOLOv11 to detect vehicles from a video feed, stores detection counts locally, and syncs with a PHP/MySQL web panel where administrators can review statistics.

## Tech Stack

**Detection (Python)**
- YOLOv11 (Ultralytics) — vehicle detection
- OpenCV — video processing
- PyQt6 — desktop GUI
- SQLite — local detection storage
- PyTorch + CUDA — GPU acceleration

**Web panel (PHP)**
- CodeIgniter 3 — backend framework
- MySQL — database
- DomPDF — report generation

## Project Structure

```
SystemCar/
├── SystemcarYOLO/     # Python detection app (YOLO + PyQt6)
│   ├── main.py              # Main GUI application
│   ├── ajustar_celdas.py    # Parking cell adjustment tool
│   ├── obtener_coordenadas.py
│   └── requirements.txt
├── systemcar/         # CodeIgniter web admin panel
│   ├── application/
│   ├── public/
│   └── index.php
└── BD/                # Database schema
    └── visaotec_systemcar.sql
```

## Setup

### Detection app (Python)

```bash
cd SystemcarYOLO
python -m venv venv
source venv/bin/activate   # On Windows: venv\Scripts\activate
pip install -r requirements.txt
```

Download a YOLOv11 model (e.g. `yolo11l.pt`) and place it in `SystemcarYOLO/`.

Run:
```bash
python main.py
```

### Web panel (PHP)

1. Install XAMPP (Apache + MySQL + PHP).
2. Place the `systemcar/` folder in `htdocs/`.
3. Create a MySQL database and import `BD/visaotec_systemcar.sql`.
4. Update database credentials in `systemcar/application/config/database.php`.
5. Access the panel via `http://localhost/systemcar/`.

## Results

- YOLOv11 model accuracy: **95%** on test videos
- CUDA acceleration reduced video processing time by **40%**


