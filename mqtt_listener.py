import paho.mqtt.client as mqtt
import mysql.connector
import json
import time

# --- 1. Konfigurasi Database ---
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'sensor_db' 
}

# --- 2. Konfigurasi MQTT ---
MQTT_BROKER = "broker.hivemq.com"
MQTT_PORT = 1883
TOPIC_SENSOR = "projekIoT/sensor"
CLIENT_ID = f'Python_Listener_{time.time()}'

# --- 3. Fungsi Callback saat Pesan Diterima ---
def on_message(client, userdata, msg):
    try:
        # Parsing data JSON dari Wokwi/ESP32
        payload = json.loads(msg.payload.decode())
        
        suhu = payload['suhu']
        humid = payload['kelembapan']
        lux = payload['lux'] 

        # Tampilkan data di terminal
        print(f"Data diterima: Suhu={suhu}, Humid={humid}, Lux={lux}")

        # Simpan ke Database
        insert_to_mysql(suhu, humid, lux)
        
    except json.JSONDecodeError:
        print(f"Error: Gagal decode JSON dari payload: {msg.payload}")
    except KeyError as e:
        # Ini terjadi jika Wokwi belum mengirim kunci 'lux'
        print(f"Error: Kunci {e} tidak ditemukan di payload. Pastikan kode Wokwi lengkap.")
    except Exception as e:
        print(f"Error umum saat memproses pesan: {e}")

# --- 4. Fungsi untuk Menyimpan Data ke MySQL ---
def insert_to_mysql(suhu, humid, lux):
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor()
        
        # Query INSERT
        query = ("INSERT INTO data_sensor (suhu, humidity, lux, timestamp) "
                 "VALUES (%s, %s, %s, NOW())")
        
        data = (suhu, humid, lux)
        
        cursor.execute(query, data)
        conn.commit()
        print("-> Data berhasil disimpan ke database.")
        
    except mysql.connector.Error as err:
        print(f"Error Database: {err}")
    finally:
        # Pastikan koneksi ditutup
        if 'conn' in locals() and conn.is_connected():
            cursor.close()
            conn.close()

# --- 5. Setup dan Loop Utama ---
def run_mqtt_client():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION1, client_id=CLIENT_ID)
    client.on_message = on_message
    
    print(f"Menghubungkan ke broker: {MQTT_BROKER}:{MQTT_PORT}")
    client.connect(MQTT_BROKER, MQTT_PORT, 60)
    
    client.subscribe(TOPIC_SENSOR)
    print(f"Berlangganan topik: {TOPIC_SENSOR}. Menunggu data...")
    
    # Memulai loop di thread terpisah (non-blocking)
    client.loop_start() 
    
    try:
        # Menjaga thread utama tetap hidup
        while True:
            time.sleep(1)
            
    except KeyboardInterrupt:
        print("\nListener dihentikan.")
        client.loop_stop()

# --- 6. Eksekusi ---
if __name__ == '__main__': # <-- PENULISAN __name__ YANG BENAR
    run_mqtt_client()