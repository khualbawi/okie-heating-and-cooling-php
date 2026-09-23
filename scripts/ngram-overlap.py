#!/usr/bin/env python3
"""Pairwise 5-gram text overlap between a set of pages on a running local server.

    python3 scripts/ngram-overlap.py http://localhost:8080 service-areas tulsa broken-arrow owasso bixby jenks sand-springs sapulpa glenpool
    python3 scripts/ngram-overlap.py http://localhost:8080 services ac-repair ac-installation ...

Extracts <main>...</main>, strips tags, lowercases, tokenizes on word boundaries,
builds the set of 5-grams per page, and reports Jaccard overlap (|A∩B| / |A∪B|)
for every pair plus the average across all pairs.
"""
import sys
import re
import urllib.request
import itertools

def fetch_main_text(url: str) -> str:
    html = urllib.request.urlopen(url, timeout=10).read().decode('utf-8', 'replace')
    m = re.search(r'<main[^>]*>(.*)</main>', html, re.S)
    body = m.group(1) if m else html
    body = re.sub(r'<script.*?</script>', ' ', body, flags=re.S)
    body = re.sub(r'<style.*?</style>', ' ', body, flags=re.S)
    text = re.sub(r'<[^>]+>', ' ', body)
    text = re.sub(r'&[a-z]+;|&#\d+;', ' ', text)
    text = text.lower()
    words = re.findall(r"[a-z0-9']+", text)
    return words

def ngrams(words, n=5):
    return set(tuple(words[i:i+n]) for i in range(len(words) - n + 1))

def main():
    base, section = sys.argv[1], sys.argv[2]
    slugs = sys.argv[3:]
    pages = {}
    for slug in slugs:
        url = f"{base}/{section}/{slug}"
        words = fetch_main_text(url)
        pages[slug] = ngrams(words)
        print(f"{slug}: {len(words)} words, {len(pages[slug])} unique 5-grams")

    print()
    overlaps = []
    for a, b in itertools.combinations(slugs, 2):
        A, B = pages[a], pages[b]
        if not A or not B:
            continue
        j = len(A & B) / len(A | B) if (A | B) else 0.0
        overlaps.append(j)
        print(f"{a:16s} x {b:16s}  {j*100:5.1f}%")

    avg = sum(overlaps) / len(overlaps) if overlaps else 0.0
    print(f"\naverage pairwise 5-gram overlap: {avg*100:.1f}%")

if __name__ == '__main__':
    main()
