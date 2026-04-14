import sqlite3

conn = sqlite3.connect("detecciones.db")
cursor = conn.cursor()

# Listar todas las tablas de la base de datos
cursor.execute("SELECT name FROM sqlite_master WHERE type='table'")
tablas = cursor.fetchall()
print("Tablas en la base de datos:", tablas)  # Debe mostrar [('conteos',)]

# Listar columnas de la tabla 'conteos'
cursor.execute("PRAGMA table_info(conteos)")
columnas = cursor.fetchall()
print("\nColumnas de 'conteos':")
for col in columnas:
    print(f"- {col[1]} ({col[2]})")  # Nombre y tipo de columna

# Mostrar los primeros 10 registros de la tabla 'conteos'
cursor.execute("SELECT * FROM conteos LIMIT 10")
registros = cursor.fetchall()
print("\nPrimeros 10 registros de 'conteos':")
for fila in registros:
    print(fila)

conn.close()
