<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>{$questionnaire->title|escape:'html'}</title>
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <th>Účastník</th>
                    <th>Otázka</th>
                    <th>Odpoveď</th>
                </tr>
            </thead>
            <tbody>
            {foreach $questionnaire_answers as $questionnaire_answer}
                {$resolved = $questionnaire->resolve_answers($questionnaire_answer->answers|unserialize)}
                {foreach $resolved as $answer}
                    <tr>
                        <td>{$questionnaire_answer->person_name} {$questionnaire_answer->person_surname}</td>
                        <td>{$answer.question}</td>
                        <td>{$answer.answer}</td>
                    </tr>
                {/foreach}
                {if not $questionnaire_answer@last}
                    <tr>
                        <td colspan="3" align="center">...</td>
                    </tr>
                {/if}
            {/foreach}
            </tbody>
        </table>
    </body>
</html>