<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8">
	<style>
	.txt-amarillo
	{
		background: yellow;
	}

	.txt-rojo
	{
		background-color: red;
	}
    </style>
  </head>
  
  <body>

  	Campo: <input type="text" id="campo" />
  	<br /><br />
  	<a href="" id="btn-AsiTalCual">Get the number and dale color al background po' wacho</a>
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function()
	{
		$('#btn-AsiTalCual').click(function(e)
		{
			e.preventDefault();

			$('#campo').removeClass('txt-rojo txt-amarillo'); // background-color por defecto

			$.ajax({
				url: 'campo-rojo-amarillo-ajax.php', // este archivo devuelve un numero
				success: function(valor)
				{
					$('#campo').val(valor); // dandole valor al campo

					// comparando el valor del campo para decidir si el background-color es rojo o amarillo
					//
					// la clase de css que use con .addClass esta arriba en el head (.txt-rojo y .txt-amarillo)
					//
					if ( $('#campo').val()>=0 && $('#campo').val()<=10 )
					{
						$('#campo').addClass('txt-rojo');
					}

					if ( $('#campo').val()>=11 && $('#campo').val()<=20 )
					{
						$('#campo').addClass('txt-amarillo');
					}
				}
			});
		});
	});
    </script>
  </body>
</html>