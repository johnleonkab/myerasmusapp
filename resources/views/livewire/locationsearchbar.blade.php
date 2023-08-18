@php
    $uuid = rand(100, 999);
@endphp
<ion-searchbar class="searchbar{{$uuid}}" debounce="1000"></ion-searchbar>
<ion-list class="lists{{$uuid}}"></ion-list>

<script>
  const searchbar{{$uuid}} = document.querySelector('.searchbar{{$uuid}}');
  const list{{$uuid}} = document.querySelector('.list{{$uuid}}');

  const data{{$uuid}} = [
    'Amsterdam',
    'Buenos Aires',
    'Cairo',
    'Geneva',
    'Hong Kong',
    'Istanbul',
    'London',
    'Madrid',
    'New York',
    'Panama City',
  ];
  let results{{$uuid}} = [...data{{$uuid}}];
  filterItems(results{{$uuid}});

  searchbar{{$uuid}}.addEventListener('ionInput', handleInput{{$uuid}});

  function handleInput{{$uuid}}(event) {
    const query = event.target.value.toLowerCase();
    results = data.filter((d) => d.toLowerCase().indexOf(query) > -1);
    filterItems(results);
  }

  function filterItems(results) {
    list.replaceChildren();

    let items = '';

    for (let i = 0; i < results.length; i++) {
      items += `
        <ion-item>
          <ion-label>${results[i]}</ion-label>
        </ion-item>
      `;
    }

    list.innerHTML = items;
  }
</script>