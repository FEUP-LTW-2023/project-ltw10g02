function editTicketUser(id_ticket){
    /* Get elements */
    const article = document.querySelector('#ticketAndComments > .ticket') 

    const h1 = document.querySelector('#ticketAndComments > .ticket > h1')
    const p = document.querySelector('#ticketAndComments > .ticket > p:nth-of-type(3)')
    const button = document.querySelector('#ticketAndComments > .ticket > button')

    /* Get text h1 and clean textContent field */
    const h1Text = h1.textContent
    h1.remove()

    /* Get text description */
    const pText = p.textContent

    /* Create h1 input */
    const inputH1 = document.createElement('input')
    inputH1.value = h1Text  

    /* Create description input */
    const inputDescription = document.createElement('textarea')
    inputDescription.value = pText

    /* Change description input style */
    inputDescription.style.overflow = 'auto'
    inputDescription.style.resize = 'none'
    inputDescription.style.height = '100px'

    /* Insert elements in page */
    article.insertBefore(inputH1, article.firstChild) 
    article.insertBefore(inputDescription, p) 

    p.remove()

    /* Change button element */
    button.textContent = 'Save ticket'
    button.onclick = async function() {
        const newH1 = document.createElement('h1')
        newH1.textContent = inputH1.value

        const newP = document.createElement('p')
        newP.textContent = inputDescription.value

        const span = document.getElementById('edit_hashtags')

        /* Change button element */
        button.textContent = 'Edit ticket'  
        button.onclick = function() {
            editTicketUser(id_ticket);
        }

        inputH1.remove()
        inputDescription.remove()

        article.insertBefore(newH1, article.firstChild) 
        article.insertBefore(newP, span)

        const data = new FormData();
        data.append('id', id_ticket);
        data.append('subject', newH1.textContent);
        data.append('description', newP.textContent);

        const response = await fetch('../actions/action_edit_ticket.php', {
            method: 'POST',
            body: data
        })

        if (!response.ok) {
            const errorMessage = await response.text()
            alert('There are an error editing the field' + errorMessage)
            newH1.textContent = h1Text
            newP.textContent = pText
        }
    }
}

async function editField(id_ticket, field){
    /* Get inicial field in database */
    const pField = document.querySelector('#edit_' + field +  '> p')
    const pFieldValue = pField.textContent

    /* Select the span element */
    const spanField = document.getElementById('edit_'+ field)
    
    const response = await fetch('../api/api_tickets_get_infos.php?id=' + id_ticket)
    const ticketsInfo = await response.json()

    console.log(pFieldValue)

    /* Create elements */
    const select = document.createElement('select')

    const p = document.createElement('p')

    const img = document.createElement('img')


    /* Create select menu */
    ticketsInfo[field].forEach(function(element) {
        const option = document.createElement('option')
        if(field !== 'priority'){
            option.textContent = element.name
            option.setAttribute('id', element.id);
        }
        else{
            option.textContent = element
        }

        if(option.textContent === pFieldValue)
            option.selected = true;
        select.appendChild(option)
    });


    /* Assigning id */

    img.id = 'edit_' + field + '_img'
    select.id = 'select_' + field

    /* Assigning data */
    
    img.src = '../images/icons/326561_box_check_icon.svg'
    img.alt = 'Check edit' + field
    img.onclick = function() {
        confirmField(id_ticket, pFieldValue, field);
    }
    
    /* Add style */
    img.style.marginLeft = '8px'


    spanField.innerHTML = ''

    /* Append Child */
    spanField.appendChild(p)
    spanField.appendChild(select)
    spanField.appendChild(img)

}

/*  Now send the data for action*/
async function confirmField(id_ticket, pFieldValue, field) {
    const select = document.getElementById('select_' + field)
    const fieldValue = select.value

    let fieldId = null;

    if(field !== 'priority'){
        const selectedOption = select.selectedOptions[0];
        fieldId = selectedOption.getAttribute('id');
    }

    console.log(id_ticket)
    console.log(field)
    console.log(fieldValue)

    const data = new FormData();
    data.append('id', id_ticket);
    data.append('field', field);
    if(field !== 'priority')
        data.append('fieldId', fieldId);
    else
        data.append('fieldValue', fieldValue);

    /* Clean span element */
    const spanField = document.getElementById('edit_' + field)
    spanField.innerHTML = ''

    /* Create elements */
    const p = document.createElement('p')
    const img = document.createElement('img')

    /* Assigning id */
    img.id = 'edit_' + field + '_img'

    /* Assigning data */
    p.textContent = fieldValue

    img.src = '../images/icons/8666681_edit_icon.svg'
    img.alt = 'Edit ' + field
    img.onclick = function() {
        editField(id_ticket, field);
    }
    
    /* Append Child */
    spanField.appendChild(p)
    spanField.appendChild(img)   

    const response = await fetch('../actions/action_edit_ticket.php', {
        method: 'POST',
        body: data
    })


    if (!response.ok) {
        const errorMessage = await response.text()
        alert('There are an error editing the field' + errorMessage)
        p.textContent = pFieldValue
    }

}
