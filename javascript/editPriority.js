function editPriority(){
    const imgEditPriority = document.getElementById('edit_priority_img')
    const id_ticket = imgEditPriority.getAttribute('data-id')

    /* Select the span element */
    const spanPriority = document.getElementById('edit_priority')
    spanPriority.innerHTML = ''
    
    /* Create elements */
    const select = document.createElement('select')

    const p = document.createElement('p')

    const optionLow = document.createElement('option')
    const optionMedium = document.createElement('option')
    const optionHigh = document.createElement('option')

    const img = document.createElement('img')

    /* Assigning id */

    img.id = 'edit_priority_img'
    select.id = 'select_priority'

    /* Assigning data */
    optionLow.value = 'Low';
    optionMedium.value = 'Medium';
    optionHigh.value = 'High';

    optionLow.textContent = 'Low'
    optionMedium.textContent = 'Medium'
    optionHigh.textContent = 'High'
    
    img.src = '../images/icons/326561_box_check_icon.svg'
    img.alt = 'Check edit priority'
    img.onclick = function() {
        confirmPriority(id_ticket);
    }
    
    /* Add style */
    img.style.marginLeft = '8px'

    /* Append Child */

    select.appendChild(optionLow)
    select.appendChild(optionMedium)
    select.appendChild(optionHigh)
    
    spanPriority.appendChild(p)
    spanPriority.appendChild(select)
    spanPriority.appendChild(img)

}

/*  Now send the data for action*/
async function confirmPriority(id_ticket) {
    
    const select = document.getElementById('select_priority')
    const priority = select.value

    console.log(id_ticket)
    console.log(priority)

    const data = new FormData();
    data.append('id', id_ticket);
    data.append('priority', priority);

    const response = await fetch('../actions/action_edit_priority.php', {
        method: 'POST',
        body: data
    })

    if (!response.ok) {
        const errorMessage = await response.text()
        alert('There are an error editing the priority: ${errorMessage}')
    }

    else {
        /* Clean span element */
        const spanPriority = document.getElementById('edit_priority')
        spanPriority.innerHTML = ''

        /* Create elements */
        const p = document.createElement('p')
        const img = document.createElement('img')

        /* Assigning id */
        img.id = 'edit_priority_img'

        /* Assigning data */
        p.textContent = priority
        img.src = '../images/icons/8666681_edit_icon.svg'
        img.alt = 'Edit priority'
        img.onclick = editPriority
        img.setAttribute('data-id', id_ticket)
        
        
        /* Append Child */
        spanPriority.appendChild(p)
        spanPriority.appendChild(img)   
    }
}


