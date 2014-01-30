<ul id="navigation">
        {% for pizza in pizzas %}
			<img src="/PizzaBuilder/resources/images/{{pizza.picturepath}}" alt="nao deu">
            <li>{{ pizza.name }}:</li>
			<ul id='sub'>
				<li>{{pizza.description}}</li>
			</ul>
        {% endfor %}
        </ul>

        <h1>My Webpage</h1>
        {{ teste }}