
// fetch url json data
 fetch('https://candaan-api.vercel.app/api/text/random')
    .then((resp) => resp.json())
    .then(function(data) {
        // show the data
        console.log(data.data);

        let output =            
            `
            <p><i>"${data.data}"</i></p>
            `;

        // show the data
        document.getElementById('joker').innerHTML = output;
    }
      //joker.innerHTML = output;
        
 
    
    
    )
    
    


    
//$('#jokes').fetch("https://candaan-api.vercel.app/api/text/random")
