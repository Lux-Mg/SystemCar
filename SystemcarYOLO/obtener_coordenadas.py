import cv2

video_path = "test_videos/4.mp4"  # Cambia la ruta si es necesario
cap = cv2.VideoCapture(video_path)

ret, frame = cap.read()
if not ret:
    print("No se pudo leer el video.")
    exit()


coords = []
drawing = False
pt1 = None
pt2 = None


# Permite ver el video más grande (por ejemplo, 1.5x el tamaño original)
cv2.namedWindow("Selecciona espacios", cv2.WINDOW_NORMAL)
scale = 1.5
new_w = int(frame.shape[1] * scale)
new_h = int(frame.shape[0] * scale)
cv2.resizeWindow("Selecciona espacios", new_w, new_h)


def mouse_callback(event, x, y, flags, param):
    global drawing, pt1, pt2, coords
    # Convertir coordenadas del mouse al tamaño original del frame
    x_orig = int(x / scale)
    y_orig = int(y / scale)
    if event == cv2.EVENT_LBUTTONDOWN:
        if not drawing:
            pt1 = (x_orig, y_orig)
            pt2 = (x_orig, y_orig)
            drawing = True
        else:
            pt2 = (x_orig, y_orig)
            coords.append((pt1[0], pt1[1], pt2[0], pt2[1]))
            drawing = False
            print(f"Espacio: ({pt1[0]}, {pt1[1]}, {pt2[0]}, {pt2[1]})")
    elif event == cv2.EVENT_MOUSEMOVE and drawing:
        pt2 = (x_orig, y_orig)


cv2.setMouseCallback("Selecciona espacios", mouse_callback)


while True:
    temp_frame = frame.copy()
    # Dibuja todos los rectángulos ya seleccionados
    for c in coords:
        cv2.rectangle(temp_frame, (c[0], c[1]), (c[2], c[3]), (0, 255, 0), 2)
    # Dibuja el rectángulo en tiempo real mientras arrastras
    if drawing and pt1 and pt2:
        cv2.rectangle(temp_frame, pt1, pt2, (255, 0, 0), 2)
    # Redimensiona el frame para mostrarlo más grande
    temp_frame_resized = cv2.resize(temp_frame, (new_w, new_h))
    cv2.imshow("Selecciona espacios", temp_frame_resized)
    key = cv2.waitKey(1) & 0xFF
    if key == ord('q') or len(coords) == 26:
        break

cv2.destroyAllWindows()
print("Coordenadas finales:")
for c in coords:
    print(c)
