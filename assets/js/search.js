document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchResults = document.querySelector(".search-results");

    searchInput.addEventListener("input", function() {
        const query = searchInput.value;

        if (query.length > 2) {
            fetch("search.php?query=" + query)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = "";
                    data.results.forEach(movie => {
                        const resultItem = document.createElement("a");
                        resultItem.href = "film.php?id=" + movie.id;
                        resultItem.textContent = movie.title;
                        searchResults.appendChild(resultItem);
                    });
                    searchResults.classList.add("show");
                })
                .catch(error => console.error('Erreur de récupération des films:', error));
        } else {
            searchResults.classList.remove("show");
        }
    });
});
