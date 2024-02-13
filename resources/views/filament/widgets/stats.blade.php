<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex justify-center text-sm">

            <img src="{{ asset('/images/logos/logo-branco.png') }}" id="logo" alt="Logo" class="h-5">
            </div>


            <script>

            function isColorDarkOrLight(rgbColor) {
              // Extrair os valores de vermelho, verde e azul da string
              const [r, g, b] = rgbColor.match(/\d+/g);
              // Calcular a luminosidade usando a fórmula padrão
              const luminosity = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
              // Definir um limiar para decidir se é uma cor escura ou clara
              const threshold = 0.5;
              // Verificar se a luminosidade é menor que o limiar
              return luminosity < threshold ? 'dark' : 'light';
            }
                var corDeFundo = getComputedStyle(document.body).backgroundColor;
                var isEscuro = isColorDarkOrLight(corDeFundo);

                console.log(isEscuro)
                var logoImg = document.getElementById('logo');
                if (isEscuro == 'dark') {
                    logoImg.src = "{{ asset('/images/logos/logo-branco.png') }}";
                } else {
                    logoImg.src = "{{ asset('/images/logos/logo-preto.png') }}";
                }
            </script>


    </x-filament::section>

</x-filament-widgets::widget>

