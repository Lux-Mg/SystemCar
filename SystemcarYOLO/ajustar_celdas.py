import cv2

# Cambia el path si tu video es diferente
cap = cv2.VideoCapture('test_videos/4.mp4')
ret, frame = cap.read()
if not ret:
    raise Exception('No se pudo leer el video')

# Coordenadas actuales (puedes pegarlas aquí para visualizarlas)
parking_spaces = [
    (704, 94, 683, 154),
    (672, 95, 646, 161),
    (637, 99, 613, 162),
    (610, 100, 580, 156),
    (574, 100, 551, 158),
    (545, 99, 512, 153),
    (508, 96, 482, 162),
    (475, 96, 440, 159),
    (421, 105, 396, 161),
    (364, 100, 334, 158),
    (688, 264, 751, 318),
    (575, 354, 646, 394),
    (421, 316, 392, 388),
    (330, 322, 301, 382),
    (238, 325, 205, 396),
    (170, 329, 138, 384),
    (110, 330, 80, 382),
    (108, 255, 137, 319),
    (160, 253, 186, 314),
    (197, 252, 231, 311),
    (264, 247, 291, 316),
    (385, 251, 415, 309),
    (270, 96, 303, 174),
    (249, 90, 214, 164),
    (209, 90, 179, 168),
    (127, 104, 86, 179)
]

# Dibuja las celdas sobre el primer frame
for idx, (x1, y1, x2, y2) in enumerate(parking_spaces):
    cv2.rectangle(frame, (x1, y1), (x2, y2), (0, 255, 0), 2)
    cv2.putText(frame, str(idx+1), (x1, y1-5),
                cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 1)

cv2.imshow('Ajustar celdas', frame)
cv2.waitKey(0)
cv2.destroyAllWindows()

# Puedes modificar las coordenadas y volver a ejecutar para ajustar visualmente.
