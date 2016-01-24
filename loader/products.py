import json
import requests
import MySQLdb

class ProductLoad(object):
	
	apiKey = "uhh7gk8be9w8v2mqj3xvgrbf"
	crawlUrl = "http://api.walmartlabs.com/v1/trends"
	insertUrl = "http://162.243.13.50/product"

	def __init__(self):
		self.conn = MySQLdb.connect(
			host = "localhost",
			user = "root",
			passwd = "swamphacks",
			db = "buyonear"			
		)

	def load(self):
		opts = {
			"apiKey": self.apiKey,
			"format": "json",
			"show": "name,regularPrice,largeImage"
		}
		r = requests.get(self.crawlUrl, params=opts)
		response = r.json()

		for i in range(len(response['items'])):
			name = response['items'][i]['name']
			price = response['items'][i]['regularPrice'] if 'regularPrice' in response['items'][i] else 0
			image = response['items'][i]['largeImage']

			requests.post(self.insertUrl, data = {
				"name": name,
				"seller": 1,
				"price": price,
				"photo": image
			})

if __name__ == "__main__":
	loader = ProductLoad()
	loader.load()
