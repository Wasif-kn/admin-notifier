<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Reset some default styles to ensure consistency */
        body, p, h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        /* Set a background color and a default font */
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        /* Styling for the main content container */
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 15px;
            background-color: #ffffff;
            border: 1px solid #959dab;
            border-radius: 2px;
           
        }

        /* Styling for headings */
        h1{
        	color: white;
        }
        h2, h3 {
            color: #333333;
            
        }

        /* Styling for paragraphs */
        p {
            color: #666666;
        }
        .headSection{
        	background-color: #7f54b3;
            padding: 30px;
            text-align: center;
            border-radius: 8px;
            margin: 10px;
        }
        .textSection{
        	border-top: 1px solid #959dab;
            padding: 10px;
        }
		table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #959dab; /* Set border color */
			margin-top: 10px;
    }

    td {
        border: 1px solid #959dab; /* Set border color */
        padding: 8px;
    }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="headSection">
            <h1><?php echo $subject; ?></h1>
        </div>
		<div class="textSection">
            <p style="color: black">A post has been <?php echo $action; ?> by <?php echo $author_name; ?>.</p>
            <table>
    			<tr>
     			   <td>Author:</td>
     			   <td><?php echo $author_name; ?></td>
   				 </tr>
   				<tr>
        			<td>Post Title:</td>
        			<td><?php echo $post_title; ?></td>
    			</tr>
    			<tr>
        			<td>Link:</td>
        			<td><?php echo $post_link; ?></td>
    			</tr>
    			<tr>
        			<td>Timestamp:</td>
        			<td><?php echo $timestamp; ?></td>
    			</tr>
			</table>
		</div>
    </div>
</body>
</html>
