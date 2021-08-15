//using jquery
const btn = $('#btn_id')
const table = $('#table_id')
const data = {} //data you want to add. Imagining this is an object
btn.on('click', function (e) {
    e.preventDefault()
    //adding the new row to the table
    table.find('tbody').append(`
        <tr>
            <td>${data.info1}</td>
            <td>${data.info2}</td>
            <td>${data.info3}</td>
            <td>${data.info4}</td>
            <td>${data.info5}</td>
        </tr>
    `)

    //sending the data to the sever using ajax
    $.post('action.url', {data: data}).then(function (response) {
        // use response here
    })
})
