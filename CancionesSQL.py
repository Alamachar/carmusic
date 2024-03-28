import requests

# Credenciales de la aplicación de Spotify
client_id = 'TU_ID'
client_secret = 'TU_ID'

# URL de autorización de Spotify
auth_url = 'https://accounts.spotify.com/api/token'

# Parámetros para la solicitud de token de acceso
payload = {
    'grant_type': 'client_credentials',
    'client_id': client_id,
    'client_secret': client_secret,
}

# Obtener token de acceso
response = requests.post(auth_url, data=payload)
access_token = response.json()['access_token']

# Lista de IDs de las playlists que quieres obtener
playlist_ids = ['PLAYLIST1', 'PLAYLIST2', 'PLAYLIST3']

# URL base para obtener información de las playlists
base_url = 'https://api.spotify.com/v1/playlists/'

# Encabezados de la solicitud con el token de acceso
headers = {
    'Authorization': 'Bearer ' + access_token
}

# Función para obtener información de una playlist
def get_playlist_info(playlist_id):
    playlist_url = base_url + playlist_id
    playlist_response = requests.get(playlist_url, headers=headers)
    playlist_data = playlist_response.json()
    return playlist_data

# Función para escapar comillas simples en nombres de artistas y canciones
def escape_quotes(name):
    return name.replace("'", "''")

# Construir consultas SQL para insertar los datos en las tablas
sql_queries = []

# Diccionario para realizar un seguimiento de los artistas ya insertados y sus IDs
inserted_artists = {}

for playlist_id in playlist_ids:
    playlist_data = get_playlist_info(playlist_id)
    playlist_name = escape_quotes(playlist_data['name'])
    playlist_description = escape_quotes(playlist_data['description'])
    playlist_tracks = []

    tracks = playlist_data['tracks']['items']
    for track in tracks:
        track_name = escape_quotes(track['track']['name'])
        first_artist = escape_quotes(track['track']['artists'][0]['name'])  # Tomar solo el primer artista
        playlist_tracks.append((track_name, first_artist))

    # Insertar el CD asociado a la playlist (asumimos que todas las canciones están en el mismo CD)
    sql_queries.append(f"INSERT INTO cds (nomcd, numcd) VALUES ('{playlist_name}', 1) ON DUPLICATE KEY UPDATE numcd=numcd+1;")

    for track_name, artist in playlist_tracks:
        # Insertar el artista en la tabla artistas (obtener el ID si ya existe)
        if artist not in inserted_artists:
            sql_queries.append(f"INSERT IGNORE INTO artistas (nombre) VALUES ('{artist}');")
            inserted_artists[artist] = f"(SELECT id FROM artistas WHERE nombre = '{artist}')"

        # Insertar la canción en la tabla canciones (ignorar si ya existe)
        sql_queries.append(f"INSERT IGNORE INTO canciones (nomcancion, id_cd, id_artista) SELECT '{track_name}', cds.id, {inserted_artists[artist]} FROM cds CROSS JOIN artistas WHERE cds.nomcd = '{playlist_name}' AND artistas.nombre = '{artist}';")

# Escribir las consultas SQL en un archivo
with open('playlist_data.sql', 'w') as file:
    for query in sql_queries:
        file.write(query + '\n')
