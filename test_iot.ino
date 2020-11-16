#include <SoftwareSerial.h>

// baudrate 設定
#define _baud        9600

// esp8266 連接設定
#define _rxpin      4
#define _txpin      5
SoftwareSerial esp8266(_rxpin,_txpin); // RX 4, TX 5

// wifi的ssid 及 密碼
#define Ssid  "\"your-wifi-ssid\""
#define Pasw  "\"your-wifi-password\""

// 連接wifi的字串
String ConnectWifi;

// 更新網頁的設定
String IP = "\"your-IP\",your-PORT";
String GET = "GET /data/update?key=631c3bf06053ead06bd293ae858cf9cf";

byte CommandClear_count=0 , ConnectServer_count=0;

void setup() {
  // put your setup code here, to run once:
  ConnectWifi = "AT+CWJAP_CUR=";
  ConnectWifi += Ssid;
  ConnectWifi += ",";
  ConnectWifi += Pasw;
  Serial.begin(_baud);
  esp8266.begin(_baud);

  delay(2000);
  InitSetting();
}

void loop() {
  // put your main code here, to run repeatedly:
   ConnectServer();
}

void Sendboth( String Str ){
  esp8266.println(Str);
  esp8266.flush();
  Serial.println("SEND:"+Str);
  Serial.flush();
}


String GetResponse( int dly ) {
  String response="";
  char c;
Wait:
dly-=1;
  while (esp8266.available()) {
    c=esp8266.read();
    response.concat(c);
    delayMicroseconds(910);
  }
  response.trim();
  delay(10);
if(dly>0) goto Wait;
  // Serial.println("\n\n\n********************");
  // Serial.println(response);
  // Serial.println("********************");
  return response;
}


/*ConnectServerSetting------------------------------------------------------------------------------------------*/
bool ConnectServer(){
  switch(ConnectServer_count){
//    delay(500);
    case 0:
      Sendboth(ConnectWifi);
      if(ConnectServerDebug( "ConnectWIFI" ,"WIFI GOT IP" , "OK", 150 ))ConnectServer_count++;
    break;
    case 1:
      Sendboth("AT+CIPSTART=\"TCP\","+IP);
      if(ConnectServerDebug( "ConnectSocketServer" ,"OK" , "OK", 25 ))ConnectServer_count++;
    break;
    case 2:
      CommandServer();
    break;
  }
}

void CommandServer(){
  // 要更新的資料
  float data1 = 23.5;
  float data2 = 55.3;
  String Str = GET + "&chart0=" + (String)data1 + "&chart1=" + (String)data2 + "\r\n";
  Sendboth( "AT+CIPSEND=" + ( (String) Str.length() ) );
  if(ConnectServerDebug( "SendTypeLength" ,">" , ">", 100 )){
    Sendboth( Str );
  }
  delay(2500);
}


bool ConnectServerDebug( String Str ,String chk1 , String chk2, byte dly ){
  String str = "";
  bool b;
  Serial.print("Check \'" + Str + "\' response ...");
  delay(dly);
  String res = GetResponse(dly*5);
  Serial.println("\n"+res);
  if(res.indexOf(chk1) != -1 | res.indexOf(chk2) != -1){
      Serial.println("OK");
      digitalWrite(13 , LOW);
      b = true;
  }
  else if( res.indexOf("LREADY CONNECTED") != -1 ){
    b=true;
  }
  else if(res.indexOf("link is not valid") != -1){
    ConnectServer_count=1;
    digitalWrite(13 , HIGH);
    b=false;
  }
  else if(res.indexOf("no ip") != -1 | res.indexOf("WIFI DISCONNECT") != -1| res.indexOf("FAIL") != -1){
    ConnectServer_count=0;
    digitalWrite(13 , HIGH);
    b=false;
  }
  else if(res.indexOf("CLOSED") != -1){
      ConnectServer_count=1;
      digitalWrite(13 , HIGH);
      b=false;
    }
  else{
    Serial.println("Error");
    b = false;
  }
  Serial.flush();
  return b;
}
/*ConnectServerSettingEnd------------------------------------------------------------------------------------------*/


/*InitSetting------------------------------------------------------------------------------------------*/
void InitSetting(){
    while(CommandClear());
}


bool CommandClear(){
  bool b = true;
  byte dly=50;
  switch(CommandClear_count){
    case 0:
      Sendboth("AT");
      if(Debug("AT","OK",dly))CommandClear_count++;
    break;
    case 1:
      Sendboth("AT+CWMODE=1");
      if(Debug("AT+CWMODE=1","OK",dly))CommandClear_count++;
    break;
    case 2:
      Sendboth("AT+CIPMODE=0");
      if(Debug("AT+CIPMODE=0","OK",dly))CommandClear_count++;
    break;
    case 3:
       Sendboth("AT+CIPCLOSE");
      if(Debug("AT+CIPCLOSE","ERROR",dly))CommandClear_count++;
    break;
    case 4:
      Sendboth("AT+CWQAP");
      if(Debug("AT+CIPMUX=0","OK",dly))CommandClear_count++;
    break;
    case 5:
      Sendboth("AT+CIPMUX=0");
      if(Debug("AT+CIPMUX=0","OK",dly)){
        CommandClear_count=0;
        b=false;
      }
    break;
    default:
      CommandClear_count=0;
    break;
  }
  return b;
}


bool Debug( String Str ,String chk, byte dly ){
  String str = "";
  bool b;
  Serial.print("Check \'" + Str + "\' response ...");
  delay(dly);
  String res = GetResponse(1);
//  Serial.println("\n"+res);
  if(res.indexOf(chk) != -1){
    Serial.println("OK");
    b = true;
  }
  else{
    Serial.println("Error");
    b = false;
  }
  Serial.flush();
  return b;
}
/*InitSettingEnd------------------------------------------------------------------------------------------*/




