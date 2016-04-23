/* Vibration Sensor ~ www.boarduino.blogspot.com */
const int vibrationSensorPin = 2; // Vibration Sensor di hubungkan ke Pin 2
int vibrationSensorState = 0; // Status saat pertama mulai = 0
int indikatorHijau = 3; // Set Pin 3 untuk LED Hijau
int indikatorMerah = 4; // Set Pin 4 untuk LED Merah
int speakerPin = 5; // Set Pin 5 untuk Buzzer

//Melody
int length = 15; // the number of notes
char notes[] = "ccggaagffeeddc "; // a space represents a rest
int beats[] = { 1, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 2, 4 };
int tempo = 300;


void playTone(int tone, int duration) {
  for (long i = 0; i < duration * 1000L; i += tone * 2) {
    digitalWrite(speakerPin, HIGH);
    delayMicroseconds(tone);
    digitalWrite(speakerPin, LOW);
    delayMicroseconds(tone);
  }
}

void playNote(char note, int duration) {
  char names[] = { 'c', 'd', 'e', 'f', 'g', 'a', 'b', 'C' };
  int tones[] = { 1915, 1700, 1519, 1432, 1275, 1136, 1014, 956 };

  // play the tone corresponding to the note name
  for (int i = 0; i < 8; i++) {
    if (names[i] == note) {
      playTone(tones[i], duration);
    }
  }
}

void setup() {
  Serial.begin(9600);
  pinMode(vibrationSensorPin, INPUT); // Jadikan Vibration sensor sebagai input
  pinMode(indikatorHijau, OUTPUT); // Jadikan indikatorHijau sebagai Output
  pinMode(indikatorMerah, OUTPUT); // Jadiikan indikatorMerah sebagai Output
  pinMode(speakerPin, OUTPUT); // Jadikan indikatorBuzzer sebagai Output
}

void loop() {
  vibrationSensorState = digitalRead(vibrationSensorPin);
  if (vibrationSensorState == HIGH) { // Jika ada getaran di sensor = HIGH
    Serial.println("Ada Pergetaran!");
    digitalWrite(indikatorHijau, HIGH); // Aktifkan indikator Hijau
    digitalWrite(indikatorMerah, LOW); // Matikan indikator Merah
    //digitalWrite(speakerPin, HIGH); // // Aktifkan indikator Buzzer
    //Melody
    for (int i = 0; i < length; i++) {
    if (notes[i] == ' ') {
      delay(beats[i] * tempo); // rest
    } else {
      playNote(notes[i], beats[i] * tempo);
    }

    // pause between notes
    delay(tempo / 2);
    }
    delay(1000); // Tunda 8 detik
    digitalWrite(indikatorHijau, LOW); // Matikan indikator Hijau
    digitalWrite(indikatorMerah, HIGH); // Aktifkan indikator Merah
    delay(100); // Delay untuk menunggu getaran selanjutnya
  }  
  else {
    digitalWrite(indikatorHijau, LOW); // Matikan indikator Hijau
    digitalWrite(indikatorMerah, HIGH); // Aktifkan indikator Merah
    digitalWrite(speakerPin, LOW); // Matikan indikator Buzzer
    Serial.println("Menunggu getaran...");
    delay(1000);
  }
}
