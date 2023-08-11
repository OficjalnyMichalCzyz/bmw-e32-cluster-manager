#include <SoftwareSerialParity.h>
SoftwareSerialParity ClusterSerial(2, 3); // RX, TX
#define MAX_INPUT_LENGTH 16

char Message[17] = "1234567890ABCDEF";

void setup() {
  Serial.begin(9600);
  ClusterSerial.begin(9600, EVEN);
}

void loop() {
  char input[MAX_INPUT_LENGTH + 1];
  int index = 0;
  if (Serial.available()) {
    while (index < MAX_INPUT_LENGTH) {
      Serial.write(String(index).c_str());
        digitalWrite(LED_BUILTIN, HIGH);
      // sprawdza, czy są dostępne dane do odczytu
      if (Serial.available()) {
        char c = Serial.read();  // odczytuje pojedynczy znak
        input[index] = c;  // zapisuje znak do bufora
        index++;  // zwiększa indeks
      }
        digitalWrite(LED_BUILTIN, LOW);
    }
    strcpy(Message, input);

  }

  delay(95);
  clusterdisplay(Message);
}

void clusterdisplay(char* input) {
  int x = 0;
  int sum = 1;
  int len = 16;
  for (int i = strlen(input); i < 16; i++) {
    input[i]=0x20;
  }

  int length = strlen(input);
  if (length > 0) {
      input[17 - 1] = '\0';
  }

  char zegary[17] = "Zegary";
  // Serial.write(zegary);
  Serial.println(input);
  ClusterSerial.write(input);
  while (len > 0){  //calculates checksum
    sum += input[x];
    len -=1;
    x += 1;
    }
  ClusterSerial.write(sum);  //sends checksum
}