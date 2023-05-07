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

        const response = await fetch('../actions/action_edit_ticket_user.php', {
            method: 'POST',
            body: data
        })

        if (!response.ok) {
            const errorMessage = await response.text()
            alert('There are an error editing the priority' + errorMessage)
            newH1.textContent = h1Text
            newP.textContent = pText
        }
    }
}
