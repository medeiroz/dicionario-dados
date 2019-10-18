//DEFINE A PROPRIEDADE DA STRING PARA SUBSTITUIR TODAS OCORRENCIAS
String.prototype.replaceAll = function(search, replacement) {
    let target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};


//DEFINE O TEMPLATE DE AMOSTRA DE CADA TABELA
let template = `
<p class="text-center title">Tabela @{{table.id}} - Descrição da tabela @{{table.name}}</p>

<table class="table">
	<tr>
		<td colspan="2" class="title text-left">Entidade/Tabela</td>
		<td colspan="4" class="descricao text-left">@{{table.name}}</td>
	</tr>
	<tr>
		<td colspan="2" class="title text-left">Descrição</td>
		<td colspan="4" class="descricao text-left">@{{table.comment}}</td>
	</tr>
	<tr>
		<td colspan="6" class="title text-center">Definição dos atributos/campos</td>
	</tr>
	<tr>
		<td class="title text-center">Nome</td>
		<td class="title text-center">Tipo</td>
		<td class="title text-center">Tamanho</td>
		<td class="title text-center">Permite Null?</td>
		<td class="title text-center">Chave</td>
		<td class="title text-center">Descrição</td>
	</tr>
	@{{registros}}
</table>

<br/><br/>
		`;

//DEFINE O TEMPLATE DE CADA COLUNA
let template_line = `
<tr>
	<td class="descricao text-left">@{{column.name}}</td>
	<td class="descricao text-center text-capitalize">@{{column.type}}</td>
	<td class="descricao text-center">@{{column.size}}</td>
	<td class="descricao text-center">@{{column.nullable}}</td>
	<td class="descricao text-center">@{{column.key}}</td>
	<td class="descricao text-left">@{{column.comment}}</td>
</tr>
		`;



axios.get('endpoint.php', {}).then(response => {

    let aux_full_html = ""

    response.data.forEach(function(value, index){

        let aux_register_html = template;
        let aux_all_lines_html = ""

        aux_register_html = aux_register_html
            .replaceAll("@{{table.id}}", index + 1)
            .replaceAll("@{{table.name}}", value.table)
            .replaceAll("@{{table.comment}}", value.comment)


        value.columns.forEach(function(_value){

            let aux_line_html = template_line

            aux_line_html = aux_line_html
                .replaceAll("@{{column.name}}",_value.description)
                .replaceAll("@{{column.type}}",_value.type)
                .replaceAll("@{{column.size}}",_value.size)
                .replaceAll("@{{column.nullable}}", _value.nullable)
                .replaceAll("@{{column.key}}", _value.key)
                .replaceAll("@{{column.comment}}",_value.comment)

            aux_all_lines_html += aux_line_html

        });

        aux_full_html += aux_register_html.replaceAll("@{{registros}}", aux_all_lines_html)

    });


    document.getElementById("container").innerHTML = aux_full_html

})
.catch(error => {
    console.log(error)
});