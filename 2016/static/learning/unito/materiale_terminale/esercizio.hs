{-	Generare la lista potenzialmente infinita dei numeri di Fibonacci usando 
	le funzioni zip e tail (e l’assioma di comprensione). Scrivere poi una 
	funzione che restituisce i primi n nmeri di Fibnacci che soddisfano un 
	certo predicato p. Fare gli esempio con i predicati di primalita’ 
	(trovare i primi n numeri di Fibonacci primi) e p divisibilità per 100 
	(trovare i primi n numeri di fbonacci divisibili per 100). -}
{-
fibonacci :: (Integer -> Bool) -> [Integer]
fibonacci p = 0 : 1 : [a + b | (a, b) <- zip (fibonacci p) (tail (fibonacci p)), p $ (+) a b]
-}
-- valuta la funzione specificata in una lista di numeri di fibonacci e restituisce solo quelli che soddisfano il predicato
fibonacci :: (Integer -> Bool) -> [Integer]
fibonacci p = filter p fib
	where
		fib = 0 : [a + b | (a, b) <- zip fib (tail fib)]
--restituisce se un numero è primo
isprim :: Integer -> Bool
isprim n	| n < 2 = False
			| n == 2 = True
			| otherwise  = isprimaus n 2
-- funzione ausiliaria di isprim
isprimaus :: Integer -> Integer -> Bool
isprimaus n m | divide n m = False | truncate (sqrt (fromInteger n)) > m = isprimaus n (m + 1) | otherwise = True
-- restituisce se il numero è divisibile per un altro
divide :: Integer -> Integer -> Bool
divide n m | mod n m == 0 = True | otherwise = False
-- restituisce se il numero specificato è divisibile per 100
div100 :: Integer -> Bool
div100 n = (mod) n 100 == 0

{-	Si rappresenti un grafo orientato aciclico come un’insieme di coppie 
	(String, String), dove ogni vertice è quindi rappresentato da una stringa.
	Una coppia (“v”, “w”) rappresenta un arco dal vertice v al vertice w. 
	Costruire una funzione che, dati due vertici u e w restituisce un cammino 
	che li collega, rappresentato come la lista dei nodi contigui che 
	collegano u a w. Se il cammino non c’è restituire la stringa vuota. 
	Usare il tipo algebrico Set nel package Data.Set. Si usi l’assioma di 
	comprensione in modo da simulare una ricerca in profondità del cammino. 
	Notare come la lazy evaluation permette di evitare il backtracking.
-}

type Nodo = String
type Arco = (Nodo, Nodo)
type Grafo = [Arco]

graph = [("a","b"), ("b","d"), ("d","e"), ("e","g"),("b","c"),("c","f"),("f", "h"),("f","e")]
graph1 = [("a", "b"), ("c", "a"), ("h","a"), ("b", "h"), ("a", "c"), ("b", "c"), ("f","c"), ("b", "d"), ("c", "d"), ("c", "f"), ("e", "d"), ("e", "f"), ("f", "i"), ("g","c")]

perccirc = ["a","b","h"]
perc = ["a","b"]

-- cerca tutti i figli del nodo specificato nel grafo specificato
searchArcoStartsWith :: Grafo -> Nodo -> Grafo
searchArcoStartsWith grafo nodo = [(x,y) | (x, y) <- grafo, x == nodo]
--rimuove l'arco specificato
rimuoviArco :: Grafo -> Arco -> Grafo
rimuoviArco grafo arco = [(x,y) | (x,y) <- grafo, x /= (fst arco), y /= (snd arco)]
--restituisce il nodo 
thereIsGoal :: Nodo -> Nodo -> Grafo -> Bool
thereIsGoal actual goal grafo = length [y | (x,y) <- (searchArcoStartsWith grafo actual), y == goal] == 1

--restituisce una lista di tutte le destinazioni di un nodo
getDestinations :: Grafo -> Nodo -> [Nodo]
getDestinations grafo nodo = [y | (x, y) <- searchArcoStartsWith grafo nodo]
--controlla se la destinazione è raggiungibile dal nodo specificato
searchCammino :: Nodo -> Nodo -> Grafo -> Bool
searchCammino actual dest grafo | actual == dest = True
								| (getDestinations grafo actual) == [] = False
								| otherwise = foldr (\x y -> y || searchCammino x dest grafo) False (getDestinations grafo actual)

cammino :: Nodo -> Nodo -> Grafo -> [Nodo]
cammino actual dest grafo 	| actual == dest = [dest]
							| searchCammino actual dest grafo == False = []
							| otherwise = actual : (cammino next dest grafo)
	where
		next = (head [x | x <- getDestinations grafo actual, searchCammino x dest grafo])


{-
2- bis . Generalizzare la funzione dell’esercizio 2 al caso di grafi che possono
contenere cicli. 
-}

--controlla che il nodo corrente non sia già stato raggiunto
passed :: Nodo -> [Nodo] -> Bool
passed nodo list | list == [] = False
				 | nodo == (head list) = True
				 | (tail list) == [] = False
				 | otherwise = passed nodo (tail list)

--controlla se la destinazione è raggiungibile dal nodo specificato
searchCamminoCirc :: Nodo -> Nodo -> [Nodo] -> Grafo -> Bool
searchCamminoCirc actual dest camm grafo | actual == dest = True
										 | (getDestinations grafo actual) == [] = False
										 | passed actual camm = False
										 | otherwise = foldr (\x y -> y || searchCamminoCirc x dest cammino grafo) False (getDestinations grafo actual)
						where cammino = camm ++ [actual]

--compone la il percorso verificando in quale nodo andare al prossimo passo
cammCirc :: Nodo -> Nodo -> [Nodo] -> Grafo -> [Nodo]
cammCirc actual dest camm grafo 	| actual == dest = [dest]
									| searchCamminoCirc actual dest camm grafo == False = []
									| otherwise = actual : (cammCirc next dest cammino grafo)
	where
		next = (head [x | x <- getDestinations grafo actual, searchCamminoCirc x dest camm grafo])
		cammino = camm ++ [actual]

-- funzione di partenza che elimina il parametro cammino mettendo una lista vuota
camminoCirc :: Nodo -> Nodo -> Grafo -> [Nodo]
camminoCirc actual dest grafo = cammCirc actual dest [] grafo