package ep.ITM;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.text.Editable;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        final EditText masa = findViewById(R.id.masa);
        final EditText visina = findViewById(R.id.visina);
        final Button button = findViewById(R.id.button);

        final TextView ITM = findViewById(R.id.ITM);
        final TextView kat = findViewById(R.id.kat);


        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final double masa1 = Integer.parseInt((masa.getText().toString()));
                final double visina1 = Integer.parseInt((visina.getText().toString()));
                final double visinam = visina1 / 100;

                final double rezultat = masa1 / (visinam * visinam);

                ITM.setText(String.valueOf((Math.round(rezultat * 10.0) / 10.0)));;

                if (rezultat <= 16.0) {
                    kat.setText("Kategorija: Huda nedohranjenost");
                }
                else if (rezultat >= 16.0 && rezultat <= 17.0) {
                    kat.setText("Kategorija: Huda nedohranjenost");
                }
                else if (rezultat >= 17.0 && rezultat <= 18.5) {
                    kat.setText("Kategorija: Blaga nedohranjenost");
                }
                else if (rezultat >= 18.5 && rezultat <= 25.0) {
                    kat.setText("Kategorija: Normalna telesna masa");
                }
                else if (rezultat >= 25.0 && rezultat <= 30.0) {
                    kat.setText("Kategorija: Zvečana telesna masa (preadipoznost)");
                }
                else if (rezultat >= 30.0 && rezultat <= 35.0) {
                    kat.setText("Kategorija: Debelost stopnje 1)");
                }
                else if (rezultat >= 35.0 && rezultat <= 40.0) {
                    kat.setText("Kategorija: Debelost stopnje 2)");
                }
                else {
                    kat.setText("Debelost stopnje III");
                }
            }
        });










    }
}