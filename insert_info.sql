SET NAMES utf8mb4;
INSERT INTO informacion (id, titulo, nosotros, problema, video, imagen) 
VALUES (
    1, 
    'SOS La Azohía - Unidos por el Litoral', 
    'Somos una asociación sin ánimo de lucro formada por vecinos, buceadores, pescadores tradicionales y amantes de la naturaleza que hemos decidido unir fuerzas para proteger el entorno privilegiado de La Azohía.\n\nNuestro objetivo principal es velar por la conservación de la bahía, su biodiversidad marina y terrestre (incluyendo el emblemático palmeral centenario y la Torre de Santa Elena), promoviendo un desarrollo sostenible que respete la esencia de este histórico pueblo pesquero murciano.', 
    'El litoral de La Azohía se enfrenta a una presión sin precedentes. El aumento del turismo masivo descontrolado, la proliferación de fondeos ilegales sobre las praderas de Posidonia oceánica, la pesca furtiva y el riesgo constante de una excesiva urbanización amenazan con destruir el delicado equilibrio ecológico de nuestra costa.\n\nDesde SOS La Azohía denunciamos estas malas prácticas y trabajamos activamente organizando limpiezas de fondos marinos, campañas de concienciación ciudadana y exigiendo a las administraciones que garanticen la protección legal que este entorno único merece.', 
    'https://www.youtube.com/watch?v=jZ5zB-0v9w0', 
    '2025-12-23-11-19-10-imagenazohia.jpg'
) ON DUPLICATE KEY UPDATE 
    titulo = VALUES(titulo),
    nosotros = VALUES(nosotros),
    problema = VALUES(problema),
    video = VALUES(video),
    imagen = VALUES(imagen);
