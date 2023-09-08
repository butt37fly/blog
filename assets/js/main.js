if (document.querySelector("#Searchbar")) {
  const form = document.querySelector("form.Searchbar");
  const input = form.querySelector("#Searchbar");
  
  const getValue = () => input.value.trim();
  
  let search;
  let target = "http://localhost/blog/search/";

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    search = getValue();

    if (search.length >= 3) {

      search = encodeURIComponent(search);
      target = `${target}${search}/`;
      target = encodeURI(target);

      window.location = target;
    }
  });
}
